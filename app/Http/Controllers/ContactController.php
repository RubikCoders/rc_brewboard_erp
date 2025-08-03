<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store a new contact form submission
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'business_name' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000',
            'preferred_contact' => 'required|in:email,phone,whatsapp',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ser un email válido',
            'business_name.required' => 'El nombre de la cafetería es obligatorio',
            'message.required' => 'El mensaje es obligatorio',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres',
            'preferred_contact.required' => 'Selecciona tu método de contacto preferido',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario');
        }

        $data = $validator->validated();

        try {
            // Create the contact lead record
            $contactLead = \App\Models\ContactLead::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'business_name' => $data['business_name'],
                'message' => $data['message'],
                'preferred_contact' => $data['preferred_contact'],
                'source' => \App\Models\ContactLead::SOURCE_LANDING_PAGE,
                'status' => \App\Models\ContactLead::STATUS_NEW,
                // Track additional info for analytics
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
                'referer' => $request->header('referer'),
            ]);

            // Log the contact attempt for internal analytics
            Log::info('New contact lead created', [
                'lead_id' => $contactLead->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'business_name' => $data['business_name'],
                'preferred_contact' => $data['preferred_contact'],
                'source' => 'landing_page',
            ]);

            // Send notifications to admin team
            $this->sendContactNotification($data, $contactLead);

            // Create Filament notification for admin panel
            $this->createFilamentNotification($contactLead);

            return back()->with(
                'success',
                '¡Gracias por tu interés! Hemos recibido tu solicitud y nos pondremos en contacto contigo dentro de las próximas 24 horas.'
            );
        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al enviar tu mensaje. Por favor intenta nuevamente.');
        }
    }

    /**
     * Send contact notification (placeholder for email logic)
     * 
     * @param array $data
     * @param \App\Models\ContactLead $contactLead
     * @return void
     */
    private function sendContactNotification(array $data, \App\Models\ContactLead $contactLead): void
    {
        // This is where you would implement email sending
        // For example, using Laravel Mail:

        /*
        \Mail::send('emails.contact-notification', [
            'lead' => $contactLead,
            'data' => $data
        ], function ($message) use ($data, $contactLead) {
            $message->to('admin@rubikcode.com')
                   ->subject('Nueva solicitud de demo - ' . $data['business_name'])
                   ->replyTo($data['email'], $data['name']);
        });
        */

        // For development, we'll just log it
        Log::info('Contact notification would be sent', [
            'lead_id' => $contactLead->id,
            'to' => 'admin@rubikcode.com',
            'subject' => 'Nueva solicitud de demo - ' . $data['business_name']
        ]);
    }

    /**
     * Create Filament notification for admin panel
     * 
     * @param \App\Models\ContactLead $contactLead
     * @return void
     */
    private function createFilamentNotification(\App\Models\ContactLead $contactLead): void
    {
        // Get all admin users to notify
        $adminUsers = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })
            ->get();

        // Fallback: if no role-based users, notify all users
        if ($adminUsers->isEmpty()) {
            $adminUsers = \App\Models\User::all();
        }

        foreach ($adminUsers as $user) {
            \Filament\Notifications\Notification::make()
                ->title('Nuevo Lead de Contacto')
                ->body("**{$contactLead->name}** de {$contactLead->business_name} solicitó una demo.")
                ->icon('heroicon-o-user-plus')
                ->iconColor('success')
                ->actions([
                    \Filament\Notifications\Actions\Action::make('view')
                        ->label('Ver Lead')
                        ->url(\App\Filament\Resources\ContactLeadResource::getUrl('view', ['record' => $contactLead]))
                        ->button(),
                    \Filament\Notifications\Actions\Action::make('assign')
                        ->label('Asignarme')
                        ->action(function () use ($contactLead, $user) {
                            $contactLead->update(['assigned_to' => $user->id]);

                            \Filament\Notifications\Notification::make()
                                ->title('Lead asignado')
                                ->body("El lead de {$contactLead->business_name} te ha sido asignado.")
                                ->success()
                                ->send();
                        })
                        ->color('primary'),
                ])
                ->sendToDatabase($user);
        }
    }
}
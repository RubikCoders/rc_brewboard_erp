<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactLead extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'business_name',
        'message',
        'preferred_contact',
        'status',
        'source',
        'notes',
        'contacted_at',
        'assigned_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contacted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Status constants
    const STATUS_NEW = 'new';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_INTERESTED = 'interested';
    const STATUS_DEMO_SCHEDULED = 'demo_scheduled';
    const STATUS_DEMO_COMPLETED = 'demo_completed';
    const STATUS_PROPOSAL_SENT = 'proposal_sent';
    const STATUS_CLOSED_WON = 'closed_won';
    const STATUS_CLOSED_LOST = 'closed_lost';

    // Preferred contact method constants
    const CONTACT_EMAIL = 'email';
    const CONTACT_PHONE = 'phone';
    const CONTACT_WHATSAPP = 'whatsapp';

    // Source constants
    const SOURCE_LANDING_PAGE = 'landing_page';
    const SOURCE_REFERRAL = 'referral';
    const SOURCE_SOCIAL_MEDIA = 'social_media';
    const SOURCE_DIRECT = 'direct';

    /**
     * Get status options for select fields
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_NEW => 'Nuevo',
            self::STATUS_CONTACTED => 'Contactado',
            self::STATUS_INTERESTED => 'Interesado',
            self::STATUS_DEMO_SCHEDULED => 'Demo Agendada',
            self::STATUS_DEMO_COMPLETED => 'Demo Completada',
            self::STATUS_PROPOSAL_SENT => 'Propuesta Enviada',
            self::STATUS_CLOSED_WON => 'Cerrado - Ganado',
            self::STATUS_CLOSED_LOST => 'Cerrado - Perdido',
        ];
    }

    /**
     * Get preferred contact options for select fields
     *
     * @return array
     */
    public static function getPreferredContactOptions(): array
    {
        return [
            self::CONTACT_EMAIL => 'Email',
            self::CONTACT_PHONE => 'Teléfono',
            self::CONTACT_WHATSAPP => 'WhatsApp',
        ];
    }

    /**
     * Get source options for select fields
     *
     * @return array
     */
    public static function getSourceOptions(): array
    {
        return [
            self::SOURCE_LANDING_PAGE => 'Landing Page',
            self::SOURCE_REFERRAL => 'Referido',
            self::SOURCE_SOCIAL_MEDIA => 'Redes Sociales',
            self::SOURCE_DIRECT => 'Directo',
        ];
    }

    /**
     * Get the status label
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusOptions()[$this->status] ?? 'Desconocido';
    }

    /**
     * Get the preferred contact label
     *
     * @return string
     */
    public function getPreferredContactLabelAttribute(): string
    {
        return self::getPreferredContactOptions()[$this->preferred_contact] ?? 'No especificado';
    }

    /**
     * Get the source label
     *
     * @return string
     */
    public function getSourceLabelAttribute(): string
    {
        return self::getSourceOptions()[$this->source] ?? 'Desconocido';
    }

    /**
     * Scope for new leads
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    /**
     * Scope for leads that need follow-up
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNeedsFollowUp($query)
    {
        return $query->whereIn('status', [
            self::STATUS_NEW,
            self::STATUS_CONTACTED,
            self::STATUS_INTERESTED,
            self::STATUS_DEMO_SCHEDULED,
            self::STATUS_DEMO_COMPLETED,
            self::STATUS_PROPOSAL_SENT,
        ]);
    }

    /**
     * Scope for closed leads
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('status', [
            self::STATUS_CLOSED_WON,
            self::STATUS_CLOSED_LOST,
        ]);
    }

    /**
     * Get the assigned user
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Mark lead as contacted
     *
     * @return bool
     */
    public function markAsContacted(): bool
    {
        return $this->update([
            'status' => self::STATUS_CONTACTED,
            'contacted_at' => now(),
        ]);
    }

    /**
     * Generate WhatsApp link
     *
     * @param string|null $message
     * @return string
     */
    public function getWhatsAppLink(?string $message = null): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (empty($phone)) {
            return '#';
        }

        // Ensure phone starts with country code
        if (!str_starts_with($phone, '52')) {
            $phone = '52' . $phone;
        }

        $defaultMessage = "Hola {$this->name}, te contacto desde Rubik Code sobre el ERP Pistacho para {$this->business_name}.";

        $text = urlencode($message ?: $defaultMessage);

        return "https://wa.me/{$phone}?text={$text}";
    }

    /**
     * Generate email link
     *
     * @param string|null $subject
     * @param string|null $body
     * @return string
     */
    public function getEmailLink(?string $subject = null, ?string $body = null): string
    {
        $defaultSubject = "Demo ERP Pistacho para {$this->business_name}";
        $defaultBody = "Hola {$this->name},\n\nGracias por tu interés en el ERP Pistacho. Me gustaría agendar una demo personalizada para {$this->business_name}.\n\n¿Cuándo tendrías disponibilidad para una llamada de 30 minutos?\n\nSaludos,\nEquipo Rubik Code";

        $params = [
            'subject' => urlencode($subject ?: $defaultSubject),
            'body' => urlencode($body ?: $defaultBody),
        ];

        return "mailto:{$this->email}?" . http_build_query($params);
    }
}
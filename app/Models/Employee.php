<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(int[] $array)
 */
class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'role_id',
        'name',
        'last_name',
        'birthdate',
        'address',
        'phone',
        'emergency_contact',
        'nss',
        'entry_date',
    ];

    //region Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(EmployeeRole::class, 'role_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    //endregion
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeRoleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $array)
 */
class EmployeeRole extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeRoleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    //region Relationships
    public function employees()
    {
        return $this->hasMany(Employee::class, 'role_id');
    }
    //endregion
}

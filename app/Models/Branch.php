<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'is_active',
    ];

    /**
     * Relationship with Users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship with Employees
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Relationship with IT Assets
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Relationship with Support Tickets
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
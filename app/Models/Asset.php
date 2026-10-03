<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'asset_tag',
        'name',
        'category',
        'asset_category_id',
        'brand',
        'model',
        'serial_number',
        'status',
        'purchase_date',
        'purchase_cost',
        'specifications',
        'employee_id',
        'vendor_id',
        'user_id',
    ];

    /**
     * Category Relationship
     */
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    /**
     * Branch Relationship
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Assigned User Relationship
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Employee Relationship
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Vendor Relationship
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Tickets Relationship
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
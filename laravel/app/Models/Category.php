<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'assigned_to'];

    /**
     * Products relationship
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Staff member assigned to this category
     */
    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

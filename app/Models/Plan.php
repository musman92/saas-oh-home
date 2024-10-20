<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
        'name',
        'amount',
        'interval',
        'interval_count',
        'description',
        'stripe_plan_id',
        'stripe_plan',
        'stripe_product_id',
        'stripe_product',
    ];
}

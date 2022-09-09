<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'delivery_status',
        'order_status',
        'package_delivery_photo',
        'delivery_personnel',
        'customer_id',
        'customer_email',
        'customer_name',
        'customer_address',
        'customer_parish',
        'customer_phone_number',
        'package_location',
        'package_street_address',
        'package_parish_address',
        'delivery_instructions',
        'fragility',
        'item_name',
        'item_payment_status',
        'item_height',
        'item_width',
        'item_weight',
        'item_description',
        'ideal_vehicle',
        'estimated_delivery_time',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PersonnelRatings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'clientName',
        'comment',
        'deliveryPersonnel',
        'dpid',
        'uid',
        'ratings',
    ];
}

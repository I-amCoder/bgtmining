<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiningHistory extends Model
{
    use HasFactory;

    protected $casts = [
        'next_mining_time' => 'datetime'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const FACTUUR = 0;
    const OFFERTE = 1;
    const BESTELLING = 2;
}

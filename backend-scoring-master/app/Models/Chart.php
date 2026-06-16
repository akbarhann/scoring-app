<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'martial_id',
        'category_id',
        'tournament_id',
        'red_name',
        'red_club',
        'red_photo',
        'blue_name',
        'blue_club',
        'blue_photo',
        'winner',
        'disqualified',
        'match_number',
        'play_now',
        'active',
        'order_code'
    ];
}

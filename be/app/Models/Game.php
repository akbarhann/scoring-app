<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'chart_id',
        'scoring_type',
        'red_points',
        'red_foul',
        'blue_points',
        'blue_foul',
    ];
}

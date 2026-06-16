<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'bracket_type',
        'category_name',
        'has_bracket',
        'actived',
    ];
}

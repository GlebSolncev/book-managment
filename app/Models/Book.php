<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'publisher',
        'author',
        'genre',
        'publication',
        'words',
        'price',
    ];

    protected $casts = [
        'publication' => 'datetime:Y-m-d',
        'price' => 'float',

    ];
}

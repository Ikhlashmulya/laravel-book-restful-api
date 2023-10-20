<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'author',
        'summary',
        'publisher',
        'total_page',
        'read_page',
        'finished'
    ];
}

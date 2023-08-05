<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Lumen\Auth\Authorizable;

class Book extends Model 
{

    use HasFactory;
    /**
     * The attributes that are mass assignable.*
     * @var string[]
     */
    protected $fillable = [
        'title', 'description', 'price', 'author_id'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $allowedFilters = [
        'name',
        'email',
    ];

    public $fillable = [
        'name',
        'email',
        'body',
    ];

    public $validationFields = [
        'name' => 'required|max:255',
        'email' => 'required|max:255|email',
        'body' => 'required',
    ];
}

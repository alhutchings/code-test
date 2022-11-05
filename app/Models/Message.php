<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $allowedFilters = [
        'user.name',
        'user.email',
    ];

    public $fillable = [
        'user_id',
        'body',
    ];

    public $validationFields = [
        'user.name' => 'required|max:255',
        'user.email' => 'required|max:255|email',
        'body' => 'required',
    ];

    public $foreign = [
        'user' => 'App\Models\User',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

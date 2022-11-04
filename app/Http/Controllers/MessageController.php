<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends MainController
{
    public function __construct()
    {
        $this->model = new Message();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    //
    public function welcomeMail()
    {
        Mail::to('recipient@example.com')->send(new WelcomeMail());

        return response()->json(['message' => 'Welcome email sent successfully!']);
    }
}

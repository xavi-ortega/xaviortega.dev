<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns'
        ]);

        $email = $request->get('email');

        User::create([
            'email' => $email
        ]);

        $url = explode('#', url()->previous())[0];

        return redirect($url)->with('status', 'Thanks for subscribing!');
    }
}

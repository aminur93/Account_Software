<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mail;

class PasswordController extends Controller
{
    public function getEmail(){
		$user_email = 'shawkatali527@gmail.com';
		$email = $user_email;
        $messageData = [
            'email' => $email,
            'name' => 'shawkat',
            'order_id' => '1',
            'productDetails' => 'hello world',
            'usersDetails' => 'hellow'
        ];
        Mail::send('email.passwords',$messageData,function ($message) use ($email){
            $message->to($email)->subject('Order Pleaced E-com Website');
        });
	}

}

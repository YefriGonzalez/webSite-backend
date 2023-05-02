<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request){
        try{
            $validateData = $request->validate([
                "email" => "required|email",
                "name"=>"required|string",
                "asunto"=>"required|string",
                "message"=>"required|string"
            ]);
            $email=$validateData['email'];
            $subject=$validateData['asunto'];
            $message=$validateData['message'];
            $name=$validateData['name'];
            Mail::to('yefrig00@gmail.com')->send(new \App\Mail\Email($email,$subject,$message,$name));
            return response()->json([
                'status' => true,
                'message' => "Email enviado correctamente"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
}

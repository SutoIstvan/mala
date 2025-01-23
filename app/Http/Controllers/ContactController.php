<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submitForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Mail::send('emails.contact', ['data' => $request->all()], function ($message) use ($request) {
            $message->to('info@mala.hu')
                    ->subject('Ajánlatkérés');
            $message->from($request->email, $request->name . ' ' . $request->surname);
        });

        return response('Köszönjük üzenetét! Hamarosan felvesszük Önnel a kapcsolatot.');
    }
}

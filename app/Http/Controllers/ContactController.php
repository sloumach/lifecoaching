<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        /* $recentMessage = Contact::where('email', $request->email)
        ->where('message', $request->message)
        ->where('created_at', '>=', now()->subMinutes(2)) // Même message en moins de 2 min
        ->exists();

        if ($recentMessage) {
            return back()->with('error', 'You can send only 2 messages per minute');
        } */
        // Validation stricte
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s-]+$/'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'name.regex' => 'The name must only contain letters, spaces, and dashes.',
        ]);

        // Vérification des erreurs
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Sécuriser les entrées avant enregistrement
        $data = $validator->validated();
        $data['name'] = strip_tags($data['name']);
        $data['subject'] = strip_tags($data['subject']);
        $data['message'] = strip_tags($data['message']);

        // Enregistrement dans la base de données
        Contact::create($data);
        flash()->success('Your message has been sent successfully!');
        return redirect()->back()->withInput();

    }
}

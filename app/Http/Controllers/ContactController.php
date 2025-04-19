<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Processa o envio do formulário de contato
     */
    public function sendMessage(Request $request)
    {
        // Validar dados do formulário
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Enviar email
            Mail::to(config('mail.from.address'))->send(new ContactFormMail($request->all()));
            
            return redirect()->back()->with('success', 'Mensagem enviada com sucesso! Em breve entraremos em contato.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente mais tarde.')
                ->withInput();
        }
    }
}

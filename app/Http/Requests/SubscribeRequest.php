<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autorizar a inscrição de qualquer usuário.
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}

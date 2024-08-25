<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Models\Board;

class InviteToBoardRequest extends BorderOwnerRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user' => ['required', 'exists:users,email']
        ];
    }
}

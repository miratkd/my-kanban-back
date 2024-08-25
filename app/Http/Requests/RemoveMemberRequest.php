<?php

namespace App\Http\Requests;

use App\Models\Board;
use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RemoveMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        if ($request->user()->id == $request['board']->user_id && $request['member']->board_id == $request['board']->id) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}

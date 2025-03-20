<?php

namespace App\Filament\Resources\WebOrderResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWebOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'user_id' => 'required|integer',
			'status' => 'required|string',
			'date' => 'required|date',
			'total_price' => 'required|numeric',
			'comment' => 'required|string'
		];
    }
}

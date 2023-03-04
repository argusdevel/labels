<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLabelsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'entity_type' => 'required|min:1|string|in:user,company,website',
            'entity_id' => 'required|min:1|numeric|exists:entities,id',
            'labels_list' => 'required|array',
            'labels_list.*' => 'int',
        ];
    }
}

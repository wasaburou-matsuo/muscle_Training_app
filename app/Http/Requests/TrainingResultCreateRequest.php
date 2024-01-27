<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingResultCreateRequest extends FormRequest
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
            //formのname属性で指定。
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:500',
        ];
    }

    public function attributes(){

        return [
            'title' => 'トレーニング名',
            'description' => 'トレーニングの説明',
        ];
    }
}

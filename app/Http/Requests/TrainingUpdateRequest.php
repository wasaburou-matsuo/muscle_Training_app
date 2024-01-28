<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingUpdateRequest extends FormRequest
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
            'category_id' => 'required',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'equipments.*.name' => 'required|string|max:50',
            'equipments.*.weight' => 'required|string|max:50',
            'steps.*' => 'required|string|max:50'        ];
    }

    public function attributes(){

        return [
            'title' => 'トレーニング名',
            'description' => 'トレーニングの説明',
            'category_id' => 'カテゴリ',
            'image' => 'レシピの画像',
            'equipments.*.name' => '材料名',
            'equipments.*.weight' => '分量',
            'steps.*' => '手順'
            
        ];
    }

            //
    }

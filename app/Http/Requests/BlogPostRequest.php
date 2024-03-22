<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255',
            'resume' => 'required|min:20|max:250',
            'content' => 'required|min:10',
            'image' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'É necessário fornecer um título!',
            'title.min' => 'O título deve ter ao menos :min caracteres!',
            'title.max' => 'O título não pode ultrapassar :max caracteres!',

            'resume.required' => 'É necessário fornecer um resumo!',
            'resume.min' => 'O resumo deve ter ao menos :min caracteres!',
            'resume.max' => 'O resumo deve ter no máximo :max caracteres!',

            'content.required' => 'É necessário fornecer um conteúdo!',
            'content.min' => 'O conteúdo deve ter ao menos :min caracteres!',

            'image.required' => 'Envie uma imagem de capa para o post!'
        ];
    }
}

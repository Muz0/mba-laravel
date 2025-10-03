<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:20480',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'content.required' => 'The content field is required.',
            'cover_image.image' => 'The cover image must be an image file.',
            'cover_image.mimes' => 'The cover image must be a file of type: jpg, jpeg, png, gif, webp.',
            'media.*.mimes' => 'Media files must be of type: jpg, jpeg, png, gif, webp, mp4, webm.',
        ];
    }
}
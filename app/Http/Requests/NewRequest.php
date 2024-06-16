<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewRequest extends FormRequest
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
        $actionMethod = $this->route()->getActionMethod();
        $rules = [];
        if ($actionMethod === 'store') {
            $rules = $this->storeNew();
        } else if ($actionMethod === 'updateNew') {
            $rules = $this->updateNew();
        } else if ($actionMethod === 'storeCategory') {
            $rules = $this->storeCategory();
        } else if ($actionMethod === 'updateCategory') {
            $rules = $this->updateCategory();
        }

        return $rules;
    }

    public function storeNew(): array
    {
        return [
            'category_id' => ['required', 'numeric', 'exists:new_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'thumbnail' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime', 'max:20480'],
        ];

    }
    public function updateNew(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'thumbnail' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime', 'max:20480'],
        ];

    }

    public function storeCategory(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'about' => ['required', 'string'],
            'image' => ['nullable', 'image'],
        ];
    }
    public function updateCategory(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'about' => ['required', 'string'],
            'image' => ['nullable', 'image'],
        ];
    }


}

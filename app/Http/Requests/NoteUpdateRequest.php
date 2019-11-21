<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'data.id' => 'required|integer',
            'data.title' => 'required|string|max:255',
            'data.body' => 'required|string',
            'data.order' => 'required|integer',
            'data.bgcolor' => 'required|string|max:255'
        ];
    }
    
    public function sanitize()
    {
        $inputs = $this->all();
        foreach ($inputs['data'] as $key => $value) {
            $inputs['data'][$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }
        $this->replace($inputs);
    }


    public function messages()
    {
        return [
        ];
    }
}
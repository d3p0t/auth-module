<?php

namespace Modules\Auth\Http\Requests;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'  => ['required'],
            'password'  => 'required',
            'remember'  => ['boolean', 'nullable'],
            'redirect'  => ['nullable']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'remember' => isset($this->remember) ? $this->remember : false
        ]);

        $this->merge([
            'redirect'  => $this->input('redirect', RouteServiceProvider::HOME)
        ]);
    }

}
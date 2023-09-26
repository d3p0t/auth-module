<?php

namespace Modules\Auth\Http\Requests\Admin;

use D3p0t\Core\Requests\ModelRequest;
use Illuminate\Validation\Rule;
use Modules\Auth\Entities\User;

class CreateUserRequest extends ModelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'  => ['required', Rule::unique('users', 'username')],
            'name'      => ['required'],
            'email'     => ['required', 'email', Rule::unique('users', 'email')],
            'role'      => ['required', Rule::exists('roles', 'id') ],
            'password'  => ['required']
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


    public function toModel(): User {
        return new User([
            'username'  => $this->validated('username'),
            'name'      => $this->validated('name'),
            'email'     => $this->validated('email'),
            'password'  => $this->validated('password')
            
        ]);
    }

    public function role(): int {
        return intval($this->validated('role'));
    }
}


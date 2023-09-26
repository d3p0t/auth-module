<?php

namespace Modules\Auth\Http\Requests\Admin;

use D3p0t\Core\Requests\ModelRequest;
use Modules\Auth\Entities\User;

class EditUserRequest extends ModelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'        => ['required'],
            'username'  => ['required', 'unique:users,username,'. $this->id],
            'name'      => ['required'],
            'email'     => ['required', 'email', 'unique:users,username,' .$this->id ],
            'role'      => ['required', 'exists:roles,id' ],
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

    public function prepareForvalidation() {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function toModel(): User {
        return new User([
            'id'        => intval($this->validated('id')),
            'username'  => $this->validated('username'),
            'name'      => $this->validated('name'),
            'email'     => $this->validated('email')
        ]);
    }

    public function role(): int {
        return intval($this->validated('role'));
    }
}

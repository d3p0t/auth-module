<?php

namespace Modules\Auth\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\Role;

class CreateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required'],
            'permissions'   => ['array']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::hasUser();
    }

    public function prepareForvalidation() {
        $this->merge([
            'permissions' => $this->input('permissions', []),
        ]);
    }

    public function toRole(): Role {
        $role = new Role([
            'name'  => $this->validated('name')
        ]);

        return $role;
    }

    public function toPermissions(): Array {
        return $this->validated(['permissions']);
    }
}

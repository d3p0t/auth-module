<?php

namespace Modules\Auth\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Entities\Role;

class EditRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => ['required'],
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
        return true;
    }

    public function prepareForvalidation() {
        $this->merge([
            'id' => $this->route('id'),
            'permissions' => $this->input('permissions', []),
        ]);
    }

    public function toRole(): Role {
        return new Role([
            'id'    => $this->validated('id'),
            'name'  => $this->validated('name')
        ]);
    }

    public function toPermissions(): Array {
        return $this->validated('permissions');
    }
}

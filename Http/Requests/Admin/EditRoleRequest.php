<?php

namespace Modules\Auth\Http\Requests\Admin;

use D3p0t\Core\Requests\ModelRequest;
use Modules\Auth\Entities\Role;

class EditRoleRequest extends ModelRequest
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

    public function toModel(): Role {
        return new Role([
            'id'    => $this->validated('id'),
            'name'  => $this->validated('name')
        ]);
    }

    public function permissions(): Array {
        return $this->validated('permissions');
    }
}

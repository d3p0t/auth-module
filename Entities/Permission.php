<?php

namespace Modules\Auth\Entities;

use Enigma\ValidatorTrait;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{

    use ValidatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public static function boot()
    {
        parent::boot();

        static::validateOnSaving();
    }

    public function validationRules(): Array {
        return [
            'name'      => ['required', "unique:permissions,name, {$this->name}"],
        ];
    }

    public $validationMessages = [
        'name.required' => 'Name field is required.',
        'name.unique' => 'Name must be unique',
    ];


}

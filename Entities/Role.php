<?php

namespace Modules\Auth\Entities;

use Enigma\ValidatorTrait;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{

    use ValidatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
    ];

    public static function boot()
    {
        parent::boot();

        static::validateOnSaving();
    }

    public function validationRules(): Array {
        return [
            'name'      => ['required', "unique:roles,name,{$this->id}"],
        ];
    }

    public $validationMessages = [
        'name.required' => 'Name field is required.',
        'name.unique' => 'Name must be unique',
    ];


}


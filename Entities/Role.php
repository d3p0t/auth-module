<?php

namespace Modules\Auth\Entities;

use Enigma\ValidatorTrait;
use Spatie\Permission\Models\Role as Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends Model
{

    use ValidatorTrait, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly(['name']);
    }

}

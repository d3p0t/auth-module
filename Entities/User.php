<?php

namespace Modules\Auth\Entities;

use Enigma\ValidatorTrait;
use Modules\Auth\Notifications\ResetPassword;
use Modules\Core\Entities\Principal;

class User extends Principal
{

    use ValidatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function boot()
    {
        parent::boot();

        static::validateOnSaving();
    }

    public function validationRules(): Array {
        return [
            'name'      => ['required'],
            'email'     => ['required', 'email', "unique:users,email,{$this->id}"],
            'username'  => ['required', "unique:users,username,{$this->id}"],
            'password'  => ['required']  
        ];
    }

    public $validationMessages = [
        'name.required' => 'Name field is required.',
        'email.required' => 'Email field is required',
        'email.email' => 'The given email is in invalid format.',
    ];

    public $validationAttributes = [
        'name' => 'User Name'
    ];


    public function sendPasswordResetNotification($token)
    {
        $params = [
            'token' => $token,
            'email' => $this->email
        ];

        $url = $this->can('admin') ? route('admin.password-reset', $params) : route('public.password-reset', $params);

        $this->notify(new ResetPassword($url));
    }
}


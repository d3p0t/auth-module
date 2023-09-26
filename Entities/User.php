<?php

namespace Modules\Auth\Entities;

use D3p0t\Core\Auth\Entities\Principal;
use Enigma\ValidatorTrait;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Notifications\ResetPassword;

class User extends Principal
{

    use ValidatorTrait, HasApiTokens;

    protected $table = 'users';

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
        'username.required' => 'The username is required',
        'username.unique'   => 'The username already exists'
    ];

    public $validationAttributes = [
        'name' => 'Name',
        'email' => 'Email',
        'username'  => 'Username'
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

    public function findForPassport(string $username): User
    {
        return $this->where('username', $username)->first();
    }
}


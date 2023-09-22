<?php

namespace Tests\Unit;

use Modules\User\Services\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{

    private UserService $sut;

    public function __construct()
    {   
        $this->sut = new UserService();
    }
    /**
     * A basic test example.
     */
    public function shouldFetchUserById(): void
    {
        $user = User::create(['username' => 'admin']);

        $res = $this->sut->getUserById($user->id);

        $this->assertEquals($res, $user);
    }
}

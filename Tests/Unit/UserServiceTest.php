<?php

namespace Tests\Unit;

use Modules\Auth\Services\UserService;
use PHPUnit\Framework\TestCase;
use Modules\Auth\Entities\User;

class UserServiceTest extends TestCase
{

    private UserService $sut;

    public function __construct()
    {   
        $this->sut = new UserService();
    }
    /**
     * A basic test example.
     * 
     * 
     * @test
     */
    public function test_should_fetch_user_by_id(): void
    {
        $user = User::create(['username' => 'admin']);

        $res = $this->sut->getUserById($user->id);

        $this->assertEquals($res, $user);
    }
}

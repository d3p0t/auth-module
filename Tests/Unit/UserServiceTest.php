<?php

namespace Tests\Unit;

use Mockery;
use Modules\Auth\Services\UserService;
use Modules\Auth\Entities\User;
use Modules\Auth\Services\RoleService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $sut;

    private RoleService $roleService;

    protected function setUp(): void {
        $this->roleService = Mockery::mock(RoleService::class);


        $this->sut = new UserService($this->roleService);

    }

    /**
     * A basic test example.
     * 
     * 
     * @test
     */
    public function test_should_fetch_user_by_id(): void
    {

        $mock = Mockery::spy(User::class);

        app()->instance(User::class, $mock);


        $user = new User();

        $mock->shouldReceive('findOrFail')->once()->andReturn($user);
    

        $res = $this->sut->getById(1);

        $this->assertEquals($res, $user);
    }
}

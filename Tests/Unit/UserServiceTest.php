<?php

namespace Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Modules\Auth\Services\UserService;
use Modules\Auth\Entities\User;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $sut;

    protected function setUp(): void {
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
        $user = new User();

        $mock = $this
            ->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOrFail'])
            ->getMock()
            ;

        $res = $this->sut->getUserById(1);

        $this->assertEquals($res, $user);
    }
}

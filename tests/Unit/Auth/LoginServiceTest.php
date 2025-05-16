<?php

namespace Tests\Unit\Auth;

use App\Services\Auth\Exceptions\LoginException;
use App\Services\Auth\LoginService;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Mockery as M;

class LoginServiceTest extends TestCase
{
    private LoginService $sut;

    private AuthFactory|(M\MockInterface&M\LegacyMockInterface) $authFactoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authFactoryMock = M::mock(AuthFactory::class);

        $this->sut = new LoginService($this->authFactoryMock);
    }

    #[Test]
    public function shouldReturnTokenSuccessfully()
    {
        $mobile = '09123456789';
        $password = 'password';
        $fakeToken = 'fake.jwt.token';

        $this->authFactoryMock
            ->expects('guard')
            ->with('api')
            ->andReturnSelf();

        $this->authFactoryMock
            ->expects('attempt')
            ->with(['mobile' => $mobile, 'password' => $password])
            ->andReturn($fakeToken);

        $result = $this->sut->login($mobile, $password);

        $this->assertEquals($fakeToken, $result);
    }

    #[Test]
    public function shouldThrowLoginExceptionWhenPasswordWrong()
    {
        $mobile = '09123456789';
        $password = 'password';

        $this->authFactoryMock
            ->expects('guard')
            ->with('api')
            ->andReturnSelf();

        $this->authFactoryMock
            ->expects('attempt')
            ->with(['mobile' => $mobile, 'password' => $password])
            ->andReturnFalse();

        $this->expectException(LoginException::class);

        $this->sut->login($mobile, $password);
    }
}

<?php

namespace Tests\Unit\User;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\User\UploadProfileImageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Contracts\Config\Repository as Config;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\UnitTestCase;

class UploadProfileImageServiceTest extends UnitTestCase
{
    private UploadProfileImageService $sut;

    private UserRepositoryInterface|(M\MockInterface&M\LegacyMockInterface) $userRepositoryMock;

    private Config|(M\MockInterface&M\LegacyMockInterface) $configMock;

    private User|(M\MockInterface&M\LegacyMockInterface) $userMock;

    private FileAdder|(M\MockInterface&M\LegacyMockInterface) $fileAdderMock;

    private Media|(M\MockInterface&M\LegacyMockInterface) $mediaMock;

    private UploadedFile|(M\MockInterface&M\LegacyMockInterface) $uploadedFileMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = M::mock(UserRepositoryInterface::class);
        $this->configMock = M::mock(Config::class);
        $this->userMock = M::mock(User::class);
        $this->fileAdderMock = m::mock(FileAdder::class);
        $this->mediaMock = m::mock(Media::class);
        $this->uploadedFileMock = m::mock(UploadedFile::class);

        $this->sut = new UploadProfileImageService($this->userRepositoryMock, $this->configMock);
    }

    #[Test]
    public function shouldUploadProfileImageSuccessfully()
    {
        $this->userRepositoryMock
            ->expects('findOrFail')
            ->andReturn($this->userMock);

        $this->userMock
            ->expects('addMedia')
            ->andReturn($this->fileAdderMock);

        $this->configMock
            ->shouldReceive('get')
            ->with('filesystems.default')
            ->andReturn('public');

        $this->fileAdderMock
            ->expects('toMediaCollection')
            ->once()
            ->andReturn($this->mediaMock);

        $result = $this->sut->upload(1, $this->uploadedFileMock);

        $this->assertInstanceOf(User::class, $result);
    }

    #[Test]
    public function shouldThrowExceptionWhenUserNotFound()
    {
        $this->userRepositoryMock
            ->expects('findOrFail')
            ->andThrow(ModelNotFoundException::class);

        $this->expectException(ModelNotFoundException::class);

        $this->sut->upload(1, $this->uploadedFileMock);
    }
}

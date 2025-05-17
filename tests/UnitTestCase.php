<?php

declare(strict_types=1);

namespace Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class UnitTestCase extends MockeryTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}

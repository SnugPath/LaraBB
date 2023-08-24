<?php

namespace Tests\Unit\Repositories;

use Mockery;
use PHPUnit\Framework\TestCase;

class ForumRepositoryTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

}

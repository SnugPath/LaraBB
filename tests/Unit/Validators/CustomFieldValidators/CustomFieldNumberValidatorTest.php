<?php

namespace Tests\Unit\Validators\CustomFieldValidators;

use App\Validators\CustomFieldValidators\Validators\CustomFieldNumberValidator;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomFieldNumberValidatorTest extends TestCase
{
    private CustomFieldNumberValidator $validator;
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new CustomFieldNumberValidator();
    }

    public function test_isValid_ReturnsTrue_WhenIsAValidInteger()
    {
        $this->assertTrue($this->validator->isValid("42"));
    }

    public function test_isValid_ReturnsFalse_WhenIsADecimal()
    {
        $this->assertFalse($this->validator->isValid("42.0"));
        $this->assertFalse($this->validator->isValid("42,0"));
    }

    public function test_isValid_ReturnsFalse_WhenIsNotAValidNumber()
    {
        $this->assertFalse($this->validator->isValid("abcd"));
    }
}

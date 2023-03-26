<?php

namespace Tests\Unit\Validators\CustomFieldValidators;

use App\Dto\CustomFieldDto;
use App\Enums\CustomFieldTypeEnum;
use App\Exceptions\CustomField\InvalidCustomFieldTypeException;
use App\Validators\CustomFieldValidators\CustomFieldValidator;
use App\Validators\CustomFieldValidators\Interfaces\CustomFieldValidatorInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomFieldValidatorTest extends TestCase
{
    private $custom_field_repository_mock;
    private CustomFieldValidatorInterface $custom_field_validator;
    private int $required_custom_field_id = 1;
    private int $optional_custom_field_id = 2;
    private int $invalid_custom_field_id = 3;
    private int $invalid_type_custom_field_id = 4;
    private CustomFieldDto $required_custom_field;
    private CustomFieldDto $optional_custom_field;
    private CustomFieldDto $invalid_type_custom_field;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpDto();
        $this->setUpRepositories();
        $this->setUpValidator();
    }

    private function setUpDto()
    {
        $this->required_custom_field = new CustomFieldDto();
        $this->required_custom_field->required = true;
        $this->required_custom_field->type = CustomFieldTypeEnum::Text->value;

        $this->optional_custom_field = new CustomFieldDto();
        $this->optional_custom_field->required = false;
        $this->optional_custom_field->type = CustomFieldTypeEnum::Number->value;

        $this->invalid_type_custom_field = new CustomFieldDto();
        $this->invalid_type_custom_field->required = false;
        $this->invalid_type_custom_field->type = -1;
    }

    private function setUpRepositories()
    {
        $this->custom_field_repository_mock = Mockery::mock('App\Repositories\CustomFieldRepository');
        $this
            ->custom_field_repository_mock
            ->shouldReceive('find')
            ->with($this->required_custom_field_id)
            ->andReturn($this->required_custom_field);

        $this
            ->custom_field_repository_mock
            ->shouldReceive('find')
            ->with($this->optional_custom_field_id)
            ->andReturn($this->optional_custom_field);

        $this
            ->custom_field_repository_mock
            ->shouldReceive('find')
            ->with($this->invalid_custom_field_id)
            ->andReturn(null);

        $this
            ->custom_field_repository_mock
            ->shouldReceive('find')
            ->with($this->invalid_type_custom_field_id)
            ->andReturn($this->invalid_type_custom_field);

    }

    private function setUpValidator()
    {
        $this->custom_field_validator = new CustomFieldValidator($this->custom_field_repository_mock);
    }

    public function test_isValid_ThrowsException_WhenInvalidCustomFieldIsSent()
    {
        $result = $this->custom_field_validator->isValid($this->invalid_custom_field_id, '');

        $this->assertFalse($result);
    }

    public function test_isValid_ReturnsFalse_WhenCustomFieldIsRequiredAndNoContentPassed()
    {
        $result = $this->custom_field_validator->isValid($this->required_custom_field_id, '');

        $this->assertFalse($result);
    }

    public function test_isValid_ReturnsTrue_WhenCustomFieldIsOptionalAndNoContentPassed()
    {
        $result = $this->custom_field_validator->isValid($this->optional_custom_field_id, '');

        $this->assertTrue($result);
    }

    public function test_isValid_UsesValidator_WhenCustomFieldPassesValidations()
    {
        $result = $this->custom_field_validator->isValid($this->optional_custom_field_id, 'abcd');

        $this->assertFalse($result);
    }

    public function test_isValid_ThrowsException_WhenCustomFieldTypeDoesntHaveValidator()
    {
        $this->expectException(InvalidCustomFieldTypeException::class);
        $this->expectExceptionMessage('Invalid custom field type');

        $this->custom_field_validator->isValid($this->invalid_type_custom_field_id, 'abcd');
    }
}

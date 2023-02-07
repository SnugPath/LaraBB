<?php

namespace Tests\Integration\Controllers;

use App\Dto\CustomFieldDto;
use App\Models\CustomField;
use App\Models\User;
use App\Repositories\CustomFieldRepository;
use App\Repositories\Interfaces\CustomFieldRepositoryInterface;
use App\Repositories\Interfaces\CustomFieldTypeRepositoryInterface;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class CustomFieldControllerTest extends TestCase
{
    private $custom_field_model_mock;
    private $created_custom_field_model_mock;
    private $custom_field_repository_mock;
    private $custom_field_type_repository_mock;
    private $controller_url = '/admin/custom-field';

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setup_models();
    }
    private function setup_models()
    {

        /** @var \Mockery\Mock */
        $this->custom_field_model_mock = Mockery::mock('App\Models\CustomField');
        /** @var \Mockery\Mock */
        $this->created_custom_field_model_mock = Mockery::mock('App\Models\CustomField');
        /** @var \Mockery\Mock */
        $this->custom_field_repository_mock = Mockery::mock('App\Repositories\Interfaces\CustomFieldRepositoryInterface');
        /** @var \Mockery\Mock */
        $this->custom_field_type_repository_mock = Mockery::mock('App\Repositories\Interfaces\CustomFieldTypeRepositoryInterface');

        $valid_custom_field = $this->getCreatedCustomFieldDto();

        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($valid_custom_field->id);
        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('name')
            ->andReturn($valid_custom_field->name);
        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn($valid_custom_field->type);
        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('default')
            ->andReturn($valid_custom_field->default);
        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('active')
            ->andReturn($valid_custom_field->active);
        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('required')
            ->andReturn($valid_custom_field->required);

        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn(Carbon::now());
        $this->created_custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn(Carbon::now());

        $this->custom_field_model_mock
            ->shouldReceive('create')
            ->andReturn($this->created_custom_field_model_mock);
        $this->custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn(Carbon::now());
        $this->custom_field_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn(Carbon::now());

        $this->custom_field_type_repository_mock
            ->shouldReceive('isValidType')
            ->withArgs(function ($arg) {
                $valid_custom_field = $this->getCreatedCustomFieldDto();
                return $arg == $valid_custom_field->type;
            })
            ->andReturn(true);
        $this->custom_field_type_repository_mock
            ->shouldReceive('isValidType')
            ->withArgs(function ($arg) {
                $valid_custom_field = $this->getCreatedCustomFieldDto();
                return $arg != $valid_custom_field->type;
            })
            ->andReturn(false);
    }

    public function test_CreateCustomField_Returns400_WhenNoNameProvided()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, []);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "A Custom Field name is required"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenEmptyNameProvided()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => '']);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "A Custom Field name is required"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenNoCustomFieldTypeProvided()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo']);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Custom field type id is mandatory"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenProvidedCustomFieldTypeIsNotAnInteger()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo', 'customFieldTypeId' => "abcd"]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Custom field type id is mandatory"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenRequiredFieldIsMissing()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo', 'customFieldTypeId' => 1]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "'Required' property must be a valid boolean"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenRequiredFieldIsNotABoolean()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo', 'customFieldTypeId' => 1, "required" => "ab"]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "'Required' property must be a valid boolean"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenActiveFieldIsMissing()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo', 'customFieldTypeId' => 1, "required" => true]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "'Active' property must be a valid boolean"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenActiveFieldIsNotABoolean()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url,
                ['name' => 'Foo', 'customFieldTypeId' => 1, "required" => true, "active" => "abcd"]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "'Active' property must be a valid boolean"
            ]);
    }

    public function test_CreateCustomField_Returns400_WhenProvidedCustomFieldTypeIdIsInvalid()
    {
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url,
                ['name' => 'Foo', 'customFieldTypeId' => 1, "required" => true, "active" => true]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Invalid custom field type sent"
            ]);
    }

    public function test_CreateCustomField_Returns200_WhenAllProvidedDataIsCorrect()
    {
        $valid_dto = $this->getCreatedCustomFieldDto();
        $this->app->instance(CustomField::class, $this->custom_field_model_mock);
        $this->app->instance(CustomFieldTypeRepositoryInterface::class, $this->custom_field_type_repository_mock);
        $this->app->instance(CustomFieldRepositoryInterface::class, $this->getCustomFieldRepository());
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url,
                ['name' => 'Foo', 'customFieldTypeId' => $valid_dto->type, "required" => true, "active" => true]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "customField" => [
                    "id" => $valid_dto->id,
                    "name" => $valid_dto->name,
                    "type" => $valid_dto->type,
                    "default" => $valid_dto->default,
                    "active" => $valid_dto->active,
                    "required" => $valid_dto->required
                ]
            ]);
    }

    private function getCreatedCustomFieldDto(): CustomFieldDto
    {
        $custom_field_dto = new CustomFieldDto();
        $custom_field_dto->id = 42;
        $custom_field_dto->name = 'Foo CustomField';
        $custom_field_dto->type = 55;
        $custom_field_dto->default = NULL;
        $custom_field_dto->active = true;
        $custom_field_dto->required = true;
        return $custom_field_dto;
    }

    private function getCustomFieldRepository(): CustomFieldRepository
    {
        return new CustomFieldRepository(
            $this->custom_field_model_mock,
            $this->custom_field_type_repository_mock
        );
    }
}

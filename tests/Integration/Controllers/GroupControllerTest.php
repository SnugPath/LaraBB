<?php

namespace Tests\Unit\Repositories;

use App\Dto\GroupDto;
use App\Models\Group;
use App\Models\User;
use Mockery;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    private $group_model_mock;
    private $created_group_model_mock;
    private $group_repository_mock;
    private $controller_url = '/admin/group';

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
        $this->group_model_mock = Mockery::mock('App\Models\Group');
        /** @var \Mockery\Mock */
        $this->created_group_model_mock = Mockery::mock('App\Models\Group');
        /** @var \Mockery\Mock */
        $this->group_repository_mock = Mockery::mock('App\Repositories\Interfaces\GroupRepositoryInterface');

        $valid_group = $this->get_created_group_dto();
        
        $this->created_group_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($valid_group->id);
        $this->created_group_model_mock
            ->shouldReceive('getAttribute')
            ->with('name')
            ->andReturn($valid_group->name);
        $this->created_group_model_mock
            ->shouldReceive('getAttribute')
            ->with('desc')
            ->andReturn($valid_group->desc);
        $this->created_group_model_mock
            ->shouldReceive('getAttribute')
            ->with('display')
            ->andReturn($valid_group->display);
        $this->created_group_model_mock
            ->shouldReceive('getAttribute')
            ->with('img')
            ->andReturn($valid_group->img);
        $this->created_group_model_mock
            ->shouldReceive('getAttribute')
            ->with('color')
            ->andReturn($valid_group->color);
        $this->group_model_mock
            ->shouldReceive('create')
            ->andReturn($this->created_group_model_mock);
        $this->group_model_mock
            ->shouldReceive('where')
            ->andReturn($this->group_model_mock);
    }

    public function test_CreateGroup_Returns400_WhenNoNameProvided()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['description' => "foo"]);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Missing required fields"
            ]);
        
    }
    
    public function test_CreateGroup_Returns400_WhenNoDescriptionProvided()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'foo']);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Missing required fields"
            ]);
    }

    
    public function test_CreateGroup_Returns200_WhenAllParametersProvided()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $this->app->instance(Group::class, $this->group_model_mock);
        $this->app->instance(GroupRepositoryInterface::class, $this->group_repository_mock);
        $valid_group = $this->get_created_group_dto();

        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => $valid_group->name, 'description' => $valid_group->desc]);

        $response
            ->assertJson(
                [
                    "code" => 200,
                    "group" => json_decode(json_encode($valid_group), true)
                ]
            )
            ->assertStatus(200);
    }

    private function get_created_group_dto()
    {
        $group_dto = new GroupDto();
        $group_dto->id = 55;
        $group_dto->name = 'Foo Group';
        $group_dto->desc = 'Foo Group Description';
        $group_dto->display = false;
        $group_dto->img = '';
        $group_dto->color = '000000';

        return $group_dto;
    }
}

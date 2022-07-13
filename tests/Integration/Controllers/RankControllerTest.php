<?php

namespace Tests\Unit\Repositories;

use App\Dto\RankDto;
use App\Models\User;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Repositories\Interfaces\RankRepositoryInterface;
use App\Repositories\RankRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class RankControllerTest extends TestCase
{
    private $rank_model_mock;
    private $created_rank_model_mock;
    private $group_repository_mock;
    private $valid_group_id = 1;
    private $invalid_group_id = 2;
    private $created_mock_id = 55;
    private $valid_rank_id = 1;
    private $invalid_rank_id = 2;
    private $rank_name = 'foo';
    private $controller_url = '/admin/rank';
    private $rank_required_error = 'A rank name is required';

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setup_required_models();
        $this->setup_required_repositories();
    }

    private function setup_required_models()
    {
        /** @var \Mockery\Mock */
        $this->rank_model_mock = Mockery::mock('App\Models\Rank');
        /** @var \Mockery\Mock */
        $this->created_rank_model_mock = Mockery::mock('App\Models\Rank');
        $this->created_rank_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($this->created_mock_id);
        $this->created_rank_model_mock
            ->shouldReceive('getAttribute')
            ->with('name')
            ->andReturn($this->rank_name);
        $this->created_rank_model_mock
            ->shouldReceive('getAttribute')
            ->with('group_id')
            ->andReturn($this->valid_group_id);
        $this->rank_model_mock
            ->shouldReceive('create')
            ->andReturn($this->created_rank_model_mock);
        $this->rank_model_mock
            ->shouldReceive('where')
            ->andReturn($this->rank_model_mock);
        $this->rank_model_mock
            ->shouldReceive('find')
            ->with($this->valid_rank_id)
            ->andReturn($this->created_rank_model_mock);
        $this->rank_model_mock
            ->shouldReceive('find')
            ->with($this->invalid_rank_id)
            ->andReturn(null);
    }

    private function setup_required_repositories()
    {
        /** @var \Mockery\Mock */
        $this->group_repository_mock = Mockery::mock('App\Repositories\Interfaces\GroupRepositoryInterface');
        $this->group_repository_mock
            ->shouldReceive('group_exists')
            ->with($this->valid_group_id)
            ->andReturn(true);
        $this->group_repository_mock
            ->shouldReceive('group_exists')
            ->with($this->invalid_group_id)
            ->andReturn(false);
    }

    public function test_CreateRank_Returns400_WhenNoNameProvided()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, []);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => $this->rank_required_error
            ]);
        
    }

    public function test_CreateRank_Returns400_WhenNameIsEmptyString()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => '']);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => $this->rank_required_error
            ]);
        
    }

    public function test_CreateRank_Returns400_WhenNameAreWhitespaces()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => '    ']);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => $this->rank_required_error
            ]);
        
    }

    public function test_CreateRank_Returns400_WhenNoGroupIdIsProvided()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo']);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Invalid group"
            ]);
    }

    public function test_CreateRank_Returns400_WhenAInvalidGroupIdIsPassed()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $this->app->instance(Rank::class, $this->rank_model_mock);
        $this->app->instance(GroupRepositoryInterface::class, $this->group_repository_mock);
        $this->app->instance(RankRepositoryInterface::class, $this->get_rank_repository());

        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo', 'group_id' => $this->invalid_group_id]);
 
        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "error" => "Invalid group"
            ]);
    }

    public function test_CreateRank_Returns200_WhenValidDataIsPassed()
    {
        $user = new User(['name' => 'John', 'type' => 1]);
        $this->app->instance(Rank::class, $this->rank_model_mock);
        $this->app->instance(GroupRepositoryInterface::class, $this->group_repository_mock);
        $this->app->instance(RankRepositoryInterface::class, $this->get_rank_repository());

        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson($this->controller_url, ['name' => 'Foo', 'group_id' => $this->valid_group_id]);
 
        $response
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "rank" => [
                    "id" => $this->created_mock_id,
                    "name" => $this->rank_name,
                    "group_id" => $this->valid_group_id
                ]
            ]);
    }


    private function get_rank_repository()
    {
        return new RankRepository(
            $this->rank_model_mock,
            $this->group_repository_mock
        );
    }
}

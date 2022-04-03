<?php

namespace Tests\Unit\Repositories;

use App\Dto\RankDto;
use App\Repositories\RankRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class RankRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    private $rank_model_mock;
    private $created_rank_model_mock;
    private $group_repository_mock;
    private $valid_group_id = 1;
    private $invalid_group_id = 2;
    private $created_mock_id = 55;
    private $valid_rank_id = 1;
    private $invalid_rank_id = 2;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setup_models();
        $this->setup_repositories();
    }

    private function setup_models()
    {
        $this->rank_model_mock = Mockery::mock('App\Models\Rank');
        $this->created_rank_model_mock = Mockery::mock('App\Models\Rank');
        $this->created_rank_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($this->created_mock_id);
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

    private function setup_repositories()
    {
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

    public function test_RankExists_ReturnsFalse_WhenInvalidRankIdIsPassed()
    {
        $rank_repository = $this->get_rank_repository();
        $rank_exists = $rank_repository->rank_exists($this->invalid_rank_id);

        $this->assertFalse($rank_exists);
    }

    public function test_RankExists_ReturnsTrue_WhenAValidRankIdIsPassed()
    {
        $rank_repository = $this->get_rank_repository();
        $rank_exists = $rank_repository->rank_exists($this->valid_rank_id);

        $this->assertTrue($rank_exists);
    }

    public function test_Create_ThrowsException_WhenAnInvalidGroupIdIsPassed()
    {
        $rank_dto = $this->get_valid_rank_dto();
        $rank_dto->group_id = $this->invalid_group_id;
        $rank_repository = $this->get_rank_repository();

        $this->expectException(ModelNotFoundException::class);  
        $this->expectExceptionMessage('Invalid group id passed');

        $rank_repository->create($rank_dto);
    }

    public function test_Create_ReturnsOk_WhenAValidRankDtoIsPassed()
    {
        $rank_dto = $this->get_valid_rank_dto();
        $rank_repository = $this->get_rank_repository();

        
        $created_rank = $rank_repository->create($rank_dto);

        $this->assertEquals($this->created_mock_id, $created_rank->id);
    }

    private function get_rank_repository()
    {
        return new RankRepository(
            $this->rank_model_mock,
            $this->group_repository_mock
        );
    }

    private function get_valid_rank_dto()
    {
        $rank_dto = new RankDto();
        $rank_dto->group_id = $this->valid_group_id;
        $rank_dto->name = "foo";

        return $rank_dto;
    }
}

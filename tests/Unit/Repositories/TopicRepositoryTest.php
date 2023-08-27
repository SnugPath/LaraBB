<?php

namespace Tests\Unit\Repositories;

use App\Dto\TopicDto;
use App\Models\Post;
use App\Repositories\Interfaces\ForumRepositoryInterface;
use App\Repositories\TopicRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class TopicRepositoryTest extends TestCase
{
    private $forum_repository_mock;
    private int $valid_forum_id = 3;
    private int $invalid_forum_id = 4;
    private int $invalid_topic_id = 123;
    private int $created_topic_id = 99;
    private int $existing_topic_id = 100;
    private $created_topic_model_mock;
    private $existing_topic_model_mock;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setupRepositories();
        $this->setupModels();
    }

    /** Create topic */

    public function test_create_ThrowsException_WhenTheForumDoesntExists()
    {
        $dto = $this->setupValidTopicDto();
        $dto->forum_id = $this->invalid_forum_id;

        $topic_model_mock = $this->setupTopicModelMock();
        $topic_repository = $this->setupTopicRepository(
            $topic_model_mock,
            $this->forum_repository_mock
        );

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Invalid forum id passed");

        $topic_repository->create($dto);
    }


    public function test_create_ReturnsTopicDto_WhenIsCreatedSuccessfully()
    {
        $dto = $this->setupValidTopicDto();

        $topic_model_mock = $this->setupTopicModelMock();
        $topic_repository = $this->setupTopicRepository(
            $topic_model_mock,
            $this->forum_repository_mock
        );

        $created_topic = $topic_repository->create($dto);
        $this->assertEquals($this->created_topic_id, $created_topic->id);
    }

    /** Edit topic */

    public function test_edit_ThrowsException_WhenTheForumDoesntExists()
    {
        $dto = $this->setupValidTopicDto();
        $dto->forum_id = $this->invalid_forum_id;

        $topic_model_mock = $this->setupTopicModelMock();
        $topic_repository = $this->setupTopicRepository(
            $topic_model_mock,
            $this->forum_repository_mock
        );

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Invalid forum id passed");

        $topic_repository->edit($dto);
    }

    public function test_edit_ThrowsException_WhenTheTopicDoesntExists()
    {
        $dto = $this->setupValidTopicDto();
        $dto->id = $this->invalid_topic_id;

        $topic_model_mock = $this->setupTopicModelMock();
        $topic_repository = $this->setupTopicRepository(
            $topic_model_mock,
            $this->forum_repository_mock
        );

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Invalid topic id passed");

        $topic_repository->edit($dto);
    }
    
    /** Private methods */

    private function setupTopicRepository($topic, $forum_repository_interface): TopicRepository
    {
        return new TopicRepository(
            $topic,
            $forum_repository_interface
        );
    }

    private function setupTopicModelMock()
    {
        $mock = Mockery::mock('App\Models\Topic');
        // Setup join
        $mock->shouldReceive('select')->andReturn($mock);
        $mock->shouldReceive('leftJoin')->andReturn($mock);
        $mock->shouldReceive('where')->andReturn($mock);
        $mock->shouldReceive('whereNull')->andReturn($mock);

        // Setup find
        $mock
            ->shouldReceive('find')
            ->with($this->created_topic_id)
            ->andReturn($this->created_topic_model_mock);
        $mock
            ->shouldReceive('find')
            ->with($this->existing_topic_model_mock)
            ->andReturn($this->existing_topic_model_mock);
        $mock
            ->shouldReceive('find')
            ->with($this->invalid_topic_id)
            ->andReturn(null);

        // Setup creation
        $mock->shouldReceive('create')->andReturn($this->created_topic_model_mock);

        return $mock;
    }

    private function setupValidTopicDto(): TopicDto
    {
        $dto = new TopicDto();

        $dto->forum_id = $this->valid_forum_id;
        $dto->approved = true;
        $dto->title = "Sample title";
        $dto->type = 1;
        $dto->created_at = Carbon::now();
        $dto->updated_at = Carbon::now();

        return $dto;
    }

    private function setupCreatedTopicDto(): TopicDto
    {
        $dto = new TopicDto();

        $dto->id = $this->created_topic_id;
        $dto->forum_id = $this->valid_forum_id;
        $dto->approved = true;
        $dto->title = "Sample title";
        $dto->type = 1;
        $dto->views = 1;
        $dto->status = 1;
        $dto->created_at = Carbon::now();
        $dto->updated_at = Carbon::now();

        return $dto;
    }

    private function setupExistingTopicDto(): TopicDto
    {
        $dto = new TopicDto();

        $dto->id = $this->existing_topic_id;
        $dto->forum_id = $this->valid_forum_id;
        $dto->approved = true;
        $dto->title = "Sample title edited";
        $dto->type = 1;
        $dto->views = 1;
        $dto->status = 1;
        $dto->created_at = Carbon::now();
        $dto->updated_at = Carbon::now();

        return $dto;
    }

    private function setupModels(): void
    {
        // Created topic mock
        $created_topic_dto = $this->setupCreatedTopicDto();
        $this->created_topic_model_mock = Mockery::mock('App\Models\Topic');
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($created_topic_dto->id);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('forum_id')
            ->andReturn($created_topic_dto->forum_id);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('approved')
            ->andReturn($created_topic_dto->approved);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('title')
            ->andReturn($created_topic_dto->title);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn($created_topic_dto->type);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('views')
            ->andReturn($created_topic_dto->views);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('status')
            ->andReturn($created_topic_dto->status);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn($created_topic_dto->created_at);
        $this->created_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn($created_topic_dto->updated_at);

        // Edited topic mock
        $existing_topic_dto = $this->setupExistingTopicDto();
        $this->existing_topic_model_mock = Mockery::mock('App\Models\Topic');
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($existing_topic_dto->id);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('forum_id')
            ->andReturn($existing_topic_dto->forum_id);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('approved')
            ->andReturn($existing_topic_dto->approved);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('title')
            ->andReturn($existing_topic_dto->title);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn($existing_topic_dto->type);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('views')
            ->andReturn($existing_topic_dto->views);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('status')
            ->andReturn($existing_topic_dto->status);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn($existing_topic_dto->created_at);
        $this->existing_topic_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn($existing_topic_dto->updated_at);
        $this->existing_topic_model_mock
            ->shouldReceive('setAttribute')
            ->andReturn(null);
        $this->existing_topic_model_mock
            ->shouldReceive('save')
            ->andReturn(null);

    }

    private function setupRepositories(): void
    {
        $this->forum_repository_mock = Mockery::mock('App\Repositories\Interfaces\ForumRepositoryInterface');
        $this->forum_repository_mock
            ->shouldReceive('forumExists')
            ->with($this->valid_forum_id)
            ->andReturn(true);
        $this->forum_repository_mock
            ->shouldReceive('forumExists')
            ->with($this->invalid_forum_id)
            ->andReturn(false);
    }

}

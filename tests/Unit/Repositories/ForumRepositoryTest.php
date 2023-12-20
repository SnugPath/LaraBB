<?php

namespace Tests\Unit\Repositories;

use App\Dto\ForumDto;
use App\Models\Forum;
use App\Repositories\ForumRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class ForumRepositoryTest extends TestCase
{
    private int $valid_forum_id = 3;
    private int $invalid_forum_id = 4;
    private $existing_forum_model_mock;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setupModels();
    }

    /** Edit */
    public function test_edit_ThrowsException_WhenAndInvalidForumIsPassed()
    {
        $forum_repository = $this->setupForumRepository();
        $dto = $this->setupExistingForumDto();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Invalid forum id passed");

        $forum_repository->edit($dto);
    }

    /** Private methods */
    private function setupForumRepository(): ForumRepository
    {
        return new ForumRepository(
            $this->setupForumModelMock()
        );
    }

    private function setupForumModelMock()
    {
        $mock = Mockery::mock('App\Models\Forum');
        // Setup join
        $mock->shouldReceive('select')->andReturn($mock);
        $mock->shouldReceive('leftJoin')->andReturn($mock);
        $mock->shouldReceive('where')->andReturn($mock);
        $mock->shouldReceive('whereNull')->andReturn($mock);
        $mock->shouldReceive('update')->andReturn($this->setupExistingForum());

        // Setup find
        $mock
            ->shouldReceive('find')
            ->with($this->valid_forum_id)
            ->andReturn($this->existing_forum_model_mock);
        $mock
            ->shouldReceive('find')
            ->with($this->invalid_forum_id)
            ->andReturn(null);

        return $mock;
    }

    private function setupExistingForum(): Forum
    {
        $forum = new Forum();
        $forum->id = $this->valid_forum_id;
        $forum->parent = null;
        $forum->name = "Foo bar baz";

        $forum->desc = "None";
        $forum->password = null;
        $forum->img = "image";
        $forum->topics_per_page = 50;
        $forum->type = 1;
        $forum->status = 1;
        $forum->last_post = null;
        $forum->last_author = null;
        $forum->display_on_index = false;
        $forum->display_indexed = false;
        $forum->display_icons = false;
        $forum->created_at = Carbon::now();
        $forum->updated_at = Carbon::now();

        return $forum;
    }

    private function setupExistingForumDto(): ForumDto
    {
        return ForumDto::fromModel($this->setupExistingForum());
    }

    private function setupModels(): void
    {
        // Edited forum mock
        $existing_forum_dto = $this->setupExistingForumDto();
        $this->existing_forum_model_mock = Mockery::mock('App\Models\Forum');
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($existing_forum_dto->id);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('desc')
            ->andReturn($existing_forum_dto->desc);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('password')
            ->andReturn($existing_forum_dto->password);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('img')
            ->andReturn($existing_forum_dto->img);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn($existing_forum_dto->type);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('topics_per_page')
            ->andReturn($existing_forum_dto->topics_per_page);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('status')
            ->andReturn($existing_forum_dto->status);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('last_post')
            ->andReturn($existing_forum_dto->last_post);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('last_author')
            ->andReturn($existing_forum_dto->last_author);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('display_on_index')
            ->andReturn($existing_forum_dto->display_on_index);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('display_indexed')
            ->andReturn($existing_forum_dto->display_indexed);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('display_icons')
            ->andReturn($existing_forum_dto->display_icons);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn($existing_forum_dto->created_at);
        $this->existing_forum_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn($existing_forum_dto->updated_at);
        $this->existing_forum_model_mock
            ->shouldReceive('setAttribute')
            ->andReturn(null);
        $this->existing_forum_model_mock
            ->shouldReceive('save')
            ->andReturn(null);
        $this->existing_forum_model_mock
            ->shouldReceive('where')
            ->andReturn($this->existing_forum_model_mock);
        $this->existing_forum_model_mock
            ->shouldReceive('update')
            ->andReturn($this->setupExistingForum());

    }
}

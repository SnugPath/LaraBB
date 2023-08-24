<?php

namespace Tests\Unit\Repositories;

use App\Dto\DraftDto;
use App\Dto\PostDto;
use App\Dto\RankDto;
use App\Exceptions\Draft\DraftIsAlreadyAPostException;
use App\Exceptions\InvalidOperationException;
use App\Models\Draft;
use App\Models\Post;
use App\Repositories\DraftRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class DraftRepositoryTest extends TestCase
{
    private $post_repository_mock;
    private $topic_repository_mock;
    private int $topic_with_draft_id = 1;
    private int $topic_without_draft_id = 2;
    private int $valid_topic_id = 3;
    private int $invalid_topic_id = 4;
    private int $valid_user_id = 1;
    private int $invalid_user_id = 2;
    private $created_draft_model_mock;
    private $existing_draft_model_mock;

    private int $created_draft_id = 42;
    private int $existing_draft_id = 42;
    private int $invalid_draft_id = 999;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setupModels();
        $this->setupRepositories();
    }

    /** Create draft **/

    public function test_create_ReturnsException_WhenTheresADraftInTheSameTopic()
    {
        $model_mock = $this->setUpDraftModelMock(new Draft());
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();
        $dto->topic_id = $this->topic_with_draft_id;

        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage("There's already a draft for this topic");

        $draft_repository->create($dto);
    }

    public function test_create_ReturnsException_WhenTheTopicDoesntExists()
    {
        $model_mock = $this->setUpDraftModelMock(null);
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();
        $dto->topic_id = $this->invalid_topic_id;

        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage("Invalid topic");

        $draft_repository->create($dto);
    }

    public function test_create_ReturnsDto_WhenIsCreatedCorrectly()
    {
        $model_mock = $this->setUpDraftModelMock(null);
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();

        $created_draft = $draft_repository->create($dto);

        $this->assertEquals($this->created_draft_id, $created_draft->id);
    }

    /** Edit draft **/

    public function test_edit_ReturnsException_WhenDraftWasAlreadyConvertedToPost()
    {
        $model_mock = $this->setUpDraftModelMock(null);
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();
        $dto->id = $this->topic_with_draft_id;

        $this->expectException(DraftIsAlreadyAPostException::class);
        $this->expectExceptionMessage("Draft was already converted to a post");

        $draft_repository->edit($dto);
    }

    public function test_edit_ReturnsException_WhenTheDraftDoesntExists()
    {
        $model_mock = $this->setUpDraftModelMock(null);
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();
        $dto->id = $this->invalid_draft_id;

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Model not found");

        $draft_repository->edit($dto);
    }

    public function test_edit_ReturnsException_WhenOtherUserTriesToEditTheDraft()
    {
        $model_mock = $this->setUpDraftModelMock(null);
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();

        $dto->id = $this->existing_draft_id;
        $dto->user_id = $this->invalid_user_id;

        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage("Only the owner of the draft can update it");

        $draft_repository->edit($dto);
    }

    /** Delete draft **/

    public function test_deleteDraft_ReturnsException_WhenAnotherUserTriesToDeleteADraft()
    {
        $model_mock = $this->setUpDraftModelMock(null);
        $draft_repository = $this->getDraftRepository($model_mock);
        $dto = $this->getValidDraftDto();

        $dto->id = $this->existing_draft_id;
        $dto->user_id = $this->invalid_user_id;

        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage("Only the owner of the draft can delete it");

        $draft_repository->deleteDraft($dto->id, $dto->user_id);
    }

    private function setupModels()
    {
        // Created draft mock
        $created_draft_dto = $this->setUpCreatedDraftDto();
        $this->created_draft_model_mock = Mockery::mock('App\Models\Draft');
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($created_draft_dto->id);
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('content')
            ->andReturn($created_draft_dto->content);
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('topic_id')
            ->andReturn($created_draft_dto->topic_id);
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('user_id')
            ->andReturn($created_draft_dto->user_id);
        $this->created_draft_model_mock
            ->shouldReceive('offsetExists')
            ->with('subject')
            ->andReturn(true);
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('subject')
            ->andReturn($created_draft_dto->subject);
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn($created_draft_dto->created_at);
        $this->created_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn($created_draft_dto->updated_at);

        // Edited draft mock
        $existing_draft = $this->setUpExistinDraftDto();
        $this->existing_draft_model_mock = Mockery::mock('App\Models\Draft');
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($existing_draft->id);
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('content')
            ->andReturn($existing_draft->content);
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('topic_id')
            ->andReturn($existing_draft->topic_id);
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('user_id')
            ->andReturn($existing_draft->user_id);
        $this->existing_draft_model_mock
            ->shouldReceive('offsetExists')
            ->with('subject')
            ->andReturn(true);
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('subject')
            ->andReturn($existing_draft->subject);
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn($existing_draft->created_at);
        $this->existing_draft_model_mock
            ->shouldReceive('getAttribute')
            ->with('updated_at')
            ->andReturn($existing_draft->updated_at);
        $this->existing_draft_model_mock
            ->shouldReceive('setAttribute')
            ->andReturn(null);
        $this->existing_draft_model_mock
            ->shouldReceive('save')
            ->andReturn(null);

    }

    private function setupRepositories()
    {
        $this->post_repository_mock = Mockery::mock('App\Repositories\Interfaces\PostRepositoryInterface');
        $this->post_repository_mock
            ->shouldReceive('findByDraftId')
            ->with($this->topic_with_draft_id)
            ->andReturn(new Post());
        $this->post_repository_mock
            ->shouldReceive('findByDraftId')
            ->with($this->topic_without_draft_id)
            ->andReturn(null);
        $this->post_repository_mock
            ->shouldReceive('findByDraftId')
            ->with($this->valid_topic_id)
            ->andReturn(null);
        $this->post_repository_mock
            ->shouldReceive('findByDraftId')
            ->with($this->invalid_topic_id)
            ->andReturn(null);
        $this->post_repository_mock
            ->shouldReceive('findByDraftId')
            ->with($this->invalid_draft_id)
            ->andReturn(null);
        $this->post_repository_mock
            ->shouldReceive('findByDraftId')
            ->with($this->existing_draft_id)
            ->andReturn(null);

        $this->topic_repository_mock = Mockery::mock('App\Repositories\Interfaces\TopicRepositoryInterface');
        $this->topic_repository_mock
            ->shouldReceive('topicExists')
            ->with($this->valid_topic_id)
            ->andReturn(true);
        $this->topic_repository_mock
            ->shouldReceive('topicExists')
            ->with($this->invalid_topic_id)
            ->andReturn(false);
    }

    private function getValidDraftDto(): DraftDto
    {
        $dto = new DraftDto();
        $dto->id = $this->topic_without_draft_id;
        $dto->topic_id = $this->valid_topic_id;
        $dto->user_id = $this->valid_user_id;
        $dto->subject = "a subject";
        $dto->content = "a content";
        return $dto;
    }

    private function getDraftRepository($draft_model_mock): DraftRepository
    {
        return new DraftRepository(
            $draft_model_mock,
            $this->post_repository_mock,
            $this->topic_repository_mock
        );
    }

    private function setUpDraftModelMock($draft_search_result)
    {
        $mock = Mockery::mock('App\Models\Draft');
        // Set up join
        $mock->shouldReceive('select')->andReturn($mock);
        $mock->shouldReceive('leftJoin')->andReturn($mock);
        $mock->shouldReceive('where')->andReturn($mock);
        $mock->shouldReceive('whereNull')->andReturn($mock);
        $mock->shouldReceive('first')->andReturn($draft_search_result);

        // Set up find
        $mock
            ->shouldReceive('find')
            ->with($this->created_draft_id)
            ->andReturn($this->created_draft_model_mock);
        $mock
            ->shouldReceive('find')
            ->with($this->existing_draft_id)
            ->andReturn($this->existing_draft_model_mock);
        $mock
            ->shouldReceive('find')
            ->with($this->invalid_draft_id)
            ->andReturn(null);

        // Set up creation
        $mock->shouldReceive('create')->andReturn($this->created_draft_model_mock);

        // Set up edit

        // Set up delete

        return $mock;
    }

    private function setUpCreatedDraftDto(): DraftDto
    {
        $dto = new DraftDto();

        $dto->id = $this->created_draft_id;
        $dto->content = "Created content";
        $dto->topic_id = $this->valid_topic_id;
        $dto->user_id = $this->valid_user_id;
        $dto->subject = null;
        $dto->created_at = Carbon::now();
        $dto->updated_at = Carbon::now();

        return $dto;
    }

    private function setUpExistinDraftDto(): DraftDto
    {
        $dto = new DraftDto();

        $dto->id = $this->existing_draft_id;
        $dto->content = "Updated content";
        $dto->topic_id = $this->valid_topic_id;
        $dto->user_id = $this->valid_user_id;
        $dto->subject = null;
        $dto->created_at = Carbon::now();
        $dto->updated_at = Carbon::now();

        return $dto;
    }
}

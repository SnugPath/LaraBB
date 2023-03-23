<?php

namespace App\Repositories;

use App\Dto\PostDto;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    protected TopicRepositoryInterface $topic_repository;
    protected UserRepositoryInterface $user_repository;

    public function __construct(
        Post $post,
        TopicRepositoryInterface $topic_repository,
        UserRepositoryInterface $user_repository
    )
    {
        parent::__construct($post);
        $this->topic_repository = $topic_repository;
        $this->user_repository = $user_repository;
    }

    public function create(PostDto $post): PostDto
    {
        $valid_topic = $this->topic_repository->topic_exists($post->topic_id);
        if(!$valid_topic)
        {
            throw new ModelNotFoundException('Invalid topic id passed');
        }

        $valid_user = $this->user_repository->user_exists($post->author);
        if(!$valid_user)
        {
            throw new ModelNotFoundException('Invalid user id for author passed');
        }

        $created_post = $this->model->create([
            'topic_id' => $post->topic_id,
            'author' => $post->author,
            'approved' => $post->approved,
            'content' => $post->content
        ]);

        $dto = new PostDto();
        $dto->id = $created_post->id;
        $dto->topic_id = $created_post->topic_id;
        $dto->author = $created_post->author;
        $dto->approved = $created_post->approved;
        $dto->content = $created_post->content;

        return $dto;

    }

    public function find_by_topic_id(int $topic_id, int $per_page = 10): array
    {
        $posts = $this->model->where('topic_id', $topic_id)->paginate($per_page);
        $posts_dto = [];
        foreach($posts as $post)
        {
            $dto = new PostDto();
            $dto->id = $post->id;
            $dto->topic_id = $post->topic_id;
            $dto->author = $post->author;
            $dto->approved = $post->approved;
            $dto->content = $post->content;
            $dto->created_at = $post->created_at;
            $dto->updated_at = $post->updated_at;
            $posts_dto[] = $dto;
        }

        return $posts_dto;
    }

    public function find_by_user_id(int $user_id, int $per_page = 10): array
    {
        $posts = $this->model->where('author', $user_id)->paginate($per_page);
        $posts_dto = [];
        foreach($posts as $post)
        {
            $dto = new PostDto();
            $dto->id = $post->id;
            $dto->topic_id = $post->topic_id;
            $dto->author = $post->author;
            $dto->approved = $post->approved;
            $dto->content = $post->content;
            $dto->created_at = $post->created_at;
            $dto->updated_at = $post->updated_at;
            $posts_dto[] = $dto;
        }

        return $posts_dto;
    }
    public function edit(PostDto $post): PostDto
    {
        $valid_topic = $this->topic_repository->topic_exists($post->topic_id);
        if(!$valid_topic)
        {
            throw new ModelNotFoundException('Invalid topic id passed');
        }

        $valid_user = $this->user_repository->user_exists($post->author);
        if(!$valid_user)
        {
            throw new ModelNotFoundException('Invalid user id for author passed');
        }

        $updated_post = $this->model->find($post->id);
        $updated_post->topic_id = $post->topic_id;
        $updated_post->author = $post->author;
        $updated_post->approved = $post->approved;
        $updated_post->content = $post->content;
        $updated_post->edit_reason = $post->edit_reason;
        $updated_post->edit_count = $post->edit_count;
        $updated_post->edit_user = $post->edit_user;
        $updated_post->save();

        $dto = new PostDto();
        $dto->id = $updated_post->id;
        $dto->topic_id = $updated_post->topic_id;
        $dto->author = $updated_post->author;
        $dto->approved = $updated_post->approved;
        $dto->content = $updated_post->content;
        $dto->edit_reason = $updated_post->edit_reason;
        $dto->edit_count = $updated_post->edit_count;
        $dto->edit_user = $updated_post->edit_user;
        $dto->created_at = $updated_post->created_at;
        $dto->updated_at = $updated_post->updated_at;

        return $dto;
    }
}

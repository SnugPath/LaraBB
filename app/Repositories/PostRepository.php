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

        return $this->model->create([
            'topic_id' => $post->topic_id,
            'author' => $post->author,
            'approved' => $post->approved,
            'content' => $post->content
        ]);

    }

    public function find_by_topic_id(int $topic_id): array
    {
        $valid_topic = $this->topic_repository->topic_exists($topic_id);
        if(!$valid_topic)
        {
            throw new ModelNotFoundException('Invalid topic id passed');
        }

        return $this->model->where('topic_id', $topic_id);

    }
}

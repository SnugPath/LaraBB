<?php

namespace App\Repositories;

use App\Dto\DraftDto;
use App\Exceptions\Draft\DraftIsAlreadyAPostException;
use App\Exceptions\InvalidOperationException;
use App\Models\Draft;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DraftRepository extends BaseRepository implements DraftRepositoryInterface
{
    private PostRepositoryInterface $post_repository;

    public function __construct(
        Draft $model,
        PostRepositoryInterface $post_repository)
    {
        parent::__construct($model);
        $this->post_repository = $post_repository;
    }

    /**
     * @param $topic_id
     * @param $user_id
     * @return bool
     */
    private function existsDraftWithoutPost($topic_id, $user_id): bool
    {
        $draft_search = $this->model
            ->select('drafts.id', 'posts.id')
            ->leftJoin('posts', function ($join) {
                $join->on('drafts.id', '=', 'posts.draft_id');
            })
            ->where('drafts.topic_id', '=', $topic_id)
            ->where('drafts.user_id', '=', $user_id)
            ->whereNull('posts.id')
            ->first();

        return !is_null($draft_search);
    }

    /**
     * @param DraftDto $draft
     * @return DraftDto
     * @throws InvalidOperationException
     */
    public function create(DraftDto $draft): DraftDto
    {
        $exists_draft_without_post = $this->existsDraftWithoutPost($draft->topic_id, $draft->user_id);
        if($exists_draft_without_post)
        {
            throw new InvalidOperationException("There's already a draft for this topic");
        }

        $created_draft = $this->model->create([
            'topic_id' => $draft->topic_id,
            'user_id' => $draft->user_id,
            'subject' => $draft->subject ?? null,
            'content' => $draft->content ?? null
        ]);

        return DraftDto::fromModel($created_draft);
    }

    /**
     * @param DraftDto $draft
     * @return DraftDto
     * @throws DraftIsAlreadyAPostException The draft was already converted to a post
     * @throws InvalidOperationException Only the owner can update the draft
     * @throws ModelNotFoundException Invalid Id was supplied
     */
    public function edit(DraftDto $draft): DraftDto
    {
        $exists_post = !is_null($this->post_repository->findByDraftId($draft->id));
        if ($exists_post)
        {
            throw new DraftIsAlreadyAPostException("Draft was already converted to a post");
        }

        $existing_draft = $this->find($draft->id);
        if (is_null($existing_draft))
        {
            throw new ModelNotFoundException("Invalid draft");
        }

        $same_user = $draft->user_id != $existing_draft->user_id;
        if (!$same_user)
        {
            throw new InvalidOperationException("Only the owner of the draft can update it");
        }

        $existing_draft->subject = $draft->subject ?? null;
        $existing_draft->content = $draft->content;

        $existing_draft->save();

        return DraftDto::fromModel($existing_draft);
    }

    /**
     * @param int $draft_id
     * @param int $user_id
     * @return void
     * @throws InvalidOperationException
     */
    public function deleteDraft(int $draft_id, int $user_id)
    {
        $draft = $this->find($draft_id);
        if ($user_id != $draft->user_id)
        {
            throw new InvalidOperationException("Only the owner of the draft can delete it");
        }

        $this->delete($draft_id);
    }
}

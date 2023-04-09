<?php

namespace App\Console\Commands;

use App\Dto\DraftDto;
use App\Dto\ForumDto;
use App\Dto\TopicDto;
use App\Models\Draft;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Topic;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use App\Repositories\Interfaces\ForumRepositoryInterface;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LocalTestCommand extends Command
{
    private ForumRepositoryInterface $forum_repository;
    private TopicRepositoryInterface $topic_repository;
    private DraftRepositoryInterface $draft_repository;

    private array $created_forums = [];
    private array $created_topics = [];
    private array $created_drafts = [];
    private array $created_posts = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:local-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        ForumRepositoryInterface $forum_repository,
        TopicRepositoryInterface $topic_repository,
        DraftRepositoryInterface $draft_repository
    )
    {
        $this->forum_repository = $forum_repository;
        $this->topic_repository = $topic_repository;
        $this->draft_repository = $draft_repository;

        try
        {
            $this->setUpForum();
            $this->setUpTopics($this->created_forums[0]);
            $this->setUpDraft($this->created_topics[0]->id, 1);
            //$this->setUpPost($this->created_topics[0]->id, $this->created_drafts[0]->id);
            $this->setUpDraft($this->created_topics[0]->id, 1);
            Log::info("All created");
        }
        catch (\Exception $ex)
        {
            Log::error("Error");
            Log::error($ex);
        }
        finally
        {
            $this->clean();
        }

        return Command::SUCCESS;
    }

    private function setUpForum()
    {
        $forumDto = new ForumDto();
        $forumDto->name = "Forum 1";
        $forumDto->parent = null;
        $forumDto->desc = null;
        $forumDto->password = null;
        $forumDto->img = "";
        $forumDto->topics_per_page = 25;
        $forumDto->type = 1;
        $forumDto->status = 1;
        $forumDto->last_post = null;
        $forumDto->last_author = null;
        $forumDto->display_indexed = false;
        $forumDto->display_icons = false;
        $forumDto->display_on_index = false;

        $this->created_forums[] = $this->forum_repository->create($forumDto);
    }

    private function setUpTopics(ForumDto $forum)
    {
        $first_topic = new TopicDto();
        $first_topic->forum_id = $forum->id;
        $first_topic->title = "First topic";
        $first_topic->approved = true;
        $first_topic->type = 1;
        $this->created_topics[] = $this->topic_repository->create($first_topic);
        $second_topic = new TopicDto();
        $second_topic->forum_id = $forum->id;
        $second_topic->title = "Second topic";
        $second_topic->approved = true;
        $second_topic->type = 1;
        $this->created_topics[] = $this->topic_repository->create($second_topic);
    }

    private function setUpDraft($topic_id, $user_id)
    {
        $dto = new DraftDto();
        $dto->topic_id = $topic_id;
        $dto->user_id = $user_id;
        $dto->content = '';
        $this->created_drafts[] = $this->draft_repository->create($dto);
    }

    private function setUpPost($topic_id, $draft_id)
    {
        $created_post = Post::create([
            'topic_id' => $topic_id,
            'author' => 1,
            'approved' => true,
            'content' => "",
            'draft_id' => $draft_id,
            'author_ip' => '',
            'edit_reason' => '',
            'edit_user' => 1
        ]);

        $this->created_posts[] = $created_post;
    }

    private function clean()
    {
        $this->cleanPosts($this->created_posts);
        $this->cleanDrafts($this->created_drafts);
        $this->cleanTopics($this->created_topics);
        $this->cleanForums($this->created_forums);
    }

    private function cleanForums(array $forums)
    {
        foreach($forums as $forum)
        {
            Forum::destroy($forum->id);
        }
    }

    private function cleanTopics(array $topics)
    {
        foreach($topics as $topic)
        {
            Topic::destroy($topic->id);
        }
    }

    private function cleanDrafts(array $drafts)
    {
        foreach($drafts as $draft)
        {
            Draft::destroy($draft->id);
        }
    }

    private function cleanPosts(array $posts)
    {
        foreach($posts as $post)
        {
            Post::destroy($post->id);
        }
    }
}

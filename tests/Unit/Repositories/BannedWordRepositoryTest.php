<?php

namespace Tests\Unit\Repositories;

use App\Dto\BannedWordDto;
use App\Exceptions\BannedWord\BannedWordIsEmptyException;
use App\Exceptions\BannedWord\InvalidWordToBanException;
use App\Exceptions\BannedWord\WordAlreadyBannedException;
use App\Exceptions\BannedWord\WordIsNotBannedException;
use App\Models\BannedWord;
use App\Repositories\BannedWordRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class BannedWordRepositoryTest extends TestCase
{
    private int $created_word_id = 55;
    private string $created_word = "aaaaa";
    private string $invalid_word = "a b cd";
    private $banned_word_model_mock;
    private $created_banned_word_model_mock;
    private array $banned_words = [
        'accaca',
        'dabacca',
        'accacaca',
        'multiple word'
    ];
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->setupModels();
    }

    /** Is banned word  **/
    public function test_isBannedWord_ReturnsTrue_WhenWordIsBanned()
    {
        $repository = $this->getBannedWordRepository();

        $is_banned_word = $repository->isBannedWord($this->banned_words[0]);

        $this->assertTrue($is_banned_word);
    }

    public function test_isBannedWord_ReturnsFalse_WhenWordIsNotBanned()
    {
        $repository = $this->getBannedWordRepository();

        $is_banned_word = $repository->isBannedWord($this->created_word);

        $this->assertFalse($is_banned_word);
    }

    /** Contains banned word **/
    public function test_containsBannedWord_ReturnsTrue_WhenTextContainsBannedWord()
    {
        $repository = $this->getBannedWordRepository();

        $text = "aaaa b cd eeeee f " . $this->banned_words[0] . " g h i lorem";

        $is_banned_word = $repository->containsBannedWord($text);

        $this->assertTrue($is_banned_word);
    }


    public function test_containsBannedWord_ReturnFalse_WhenTextDoesntContainABannedWord()
    {
        $repository = $this->getBannedWordRepository();

        $text = "aaaa b cd eeeee f g h i lorem";

        $is_banned_word = $repository->containsBannedWord($text);

        $this->assertFalse($is_banned_word);
    }

    /** Create Banned Word **/

    public function test_createBannedWord_ThrowsException_WhenWordIsEmpty()
    {
        $repository = $this->getBannedWordRepository();

        $this->expectException(BannedWordIsEmptyException::class);
        $this->expectExceptionMessage("Word must have at least one character");

        $dto = $this->setupCreatedBannedWordDto();
        $dto->word = "";

        $repository->createBannedWord($dto);
    }

    public function test_createBannedWord_ThrowsException_WhenWordIsAlreadyBanned()
    {
        $repository = $this->getBannedWordRepository();

        $this->expectException(WordAlreadyBannedException::class);
        $this->expectExceptionMessage("Word is already banned");

        $dto = $this->setupCreatedBannedWordDto();
        $dto->word = $this->banned_words[0];

        $repository->createBannedWord($dto);
    }

    public function test_createBannedWord_ThrowsException_WhenWordHasWhitespaces()
    {
        $repository = $this->getBannedWordRepository();

        $this->expectException(InvalidWordToBanException::class);
        $this->expectExceptionMessage("Word must be single");

        $dto = $this->setupCreatedBannedWordDto();
        $dto->word = $this->invalid_word;

        $repository->createBannedWord($dto);
    }

    public function test_createBannedWord_ReturnsCreatedDto_WhenWordIsNotBannedAlready()
    {
        $repository = $this->getBannedWordRepository();

        $dto = $this->setupCreatedBannedWordDto();

        $created_word = $repository->createBannedWord($dto);

        $this->assertEquals($this->created_word_id, $created_word->id);
    }

    /** Delete Banned Word **/

    public function test_deleteBannedWord_ThrowsException_WhenWordIsNotBanned()
    {
        $repository = $this->getBannedWordRepository();

        $this->expectException(WordIsNotBannedException::class);
        $this->expectExceptionMessage("Word is not banned");

        $word = $this->created_word;

        $repository->deleteBannedWord($word);
    }

    private function setUpModels()
    {
        // Banned word model mock
        $model_list = [];
        $this->banned_word_model_mock = Mockery::mock('App\Models\BannedWord');
        foreach ($this->banned_words as $index=>$banned_word)
        {
            $banned_word_model = new BannedWord();
            $banned_word_model->id = $index + 1;
            $banned_word_model->word = $banned_word;

            $model_list[] = $banned_word_model;

            $banned_word_search_result = Mockery::mock('App\Models\BannedWord');
            $banned_word_search_result
                ->shouldReceive('first')
                ->andReturn($banned_word_model);

            $this->banned_word_model_mock
                ->shouldReceive('where')
                ->with('word', '=', $banned_word)
                ->andReturn($banned_word_search_result);
        }

        $null_search_result = Mockery::mock('App\Models\BannedWord');
        $null_search_result
            ->shouldReceive('first')
            ->andReturn(null);

        $this->banned_word_model_mock
            ->shouldReceive('where')
            ->with('word', '=', $this->created_word)
            ->andReturn($null_search_result);

        $this->banned_word_model_mock
            ->shouldReceive('all')
            ->andReturn($model_list);

        // Created banned word model mock
        $this->created_banned_word_model_mock = Mockery::mock('App\Models\BannedWord');
        $this->created_banned_word_model_mock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($this->created_word_id);

        $this->created_banned_word_model_mock
            ->shouldReceive('getAttribute')
            ->with('word')
            ->andReturn($this->created_word);

        $this->banned_word_model_mock
            ->shouldReceive('create')
            ->andReturn($this->created_banned_word_model_mock);
    }

    private function setupCreatedBannedWordDto(): BannedWordDto
    {
        $dto = new BannedWordDto();

        $dto->id = $this->created_word_id;
        $dto->word = $this->created_word;

        return $dto;
    }

    private function getBannedWordRepository()
    {
        return new BannedWordRepository($this->banned_word_model_mock);
    }
}

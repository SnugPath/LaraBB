<?php

namespace App\Repositories;

use App\Dto\BannedWordDto;
use App\Exceptions\BannedWord\BannedWordIsEmptyException;
use App\Exceptions\BannedWord\InvalidWordToBanException;
use App\Exceptions\BannedWord\WordAlreadyBannedException;
use App\Exceptions\BannedWord\WordIsNotBannedException;
use App\Models\BannedWord;
use App\Repositories\Interfaces\BannedWordRepositoryInterface;

class BannedWordRepository extends BaseRepository implements BannedWordRepositoryInterface
{
    public function __construct(BannedWord $user)
    {
        parent::__construct($user);
    }

    private function getBannedWord(string $word)
    {
        $sanitized_word = trim(strtolower($word));
        return $this->model->where('word', '=', $sanitized_word)->first();
    }

    /**
     * Checks if a word is banned
     * @param string $word
     * @return bool
     */
    public function isBannedWord(string $word): bool
    {
        $word_search = $this->getBannedWord($word);
        return !is_null($word_search);
    }

    /**
     * Check whether a text contains a banned word or not
     * @param string $text
     * @return bool
     */
    public function containsBannedWord(string $text): bool
    {
        // Retrieve words and build a 'dictionary' with them
        $banned_words_search = $this->model->all();
        $banned_words = [];
        foreach ($banned_words_search as $banned_word)
        {
            $banned_words[$banned_word->word] = true;
        }

        // Extract all words from the text
        $sanitize_word_lambda = function (string $word): string {
            return trim(strtolower($word));
        };

        $text_words = array_filter(
            array_map(
                $sanitize_word_lambda,
                explode(' ', $text)
            ),
            'strlen'
        );

        // Check if we have any word in our dictionary
        foreach ($text_words as $word)
        {
            if(array_key_exists($word, $banned_words))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param BannedWordDto $dto
     * @return BannedWordDto
     * @throws BannedWordIsEmptyException
     * @throws WordAlreadyBannedException
     */
    public function createBannedWord(BannedWordDto $dto): BannedWordDto
    {
        $word = trim(strtolower($dto->word ?? ''));
        if (strlen($word) == 0)
        {
            throw new BannedWordIsEmptyException("Word must have at least one character");
        }

        $is_multiple_word = sizeof(explode(' ', $word)) > 1;
        if ($is_multiple_word)
        {
            throw new InvalidWordToBanException("Word must be single");
        }

        $exists_word = $this->isBannedWord($word);
        if($exists_word)
        {
            throw new WordAlreadyBannedException("Word is already banned");
        }

        $created_word = $this->model->create([
            'word' => $word
        ]);

        return BannedWordDto::fromModel($created_word);
    }

    /**
     * @param string $word
     * @return void
     * @throws WordIsNotBannedException
     */
    public function deleteBannedWord(string $word): void
    {
        $word_search = $this->getBannedWord($word);
        if (is_null($word_search))
        {
            throw new WordIsNotBannedException("Word is not banned");
        }

        $word_search->delete();
    }
}

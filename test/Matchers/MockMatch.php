<?php

namespace ZxcvbnPhp\Test\Matchers;

use ZxcvbnPhp\Matchers\BaseMatch;

class MockMatch extends BaseMatch
{
    protected $guesses;

    public function __construct(int $begin, int $end, int $guesses)
    {
        parent::__construct('', $begin, $end, '');
        $this->guesses = $guesses;
    }

    /**
     * Get feedback to a user based on the match.
     * @param  bool $isSoleMatch
     *   Whether this is the only match in the password
     * @return array
     *   Associative array with warning (string) and suggestions (array of strings)
     */
    public function getFeedback(bool $isSoleMatch): array
    {
        return [];
    }

    public function getRawGuesses(): int
    {
        return $this->guesses;
    }

    /**
     * Match this password.
     *
     * @param string $password
     *   Password to check for match.
     * @param array $userInputs
     *   Array of values related to the user (optional).
     * @code
     *   array('Alice Smith')
     * @endcode
     * @return array
     *   Array of Match objects
     */
    public static function match(string $password, array $userInputs = []): array
    {
        return [];
    }
}

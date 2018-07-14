<?php

namespace ZxcvbnPhp\Matchers;

use ZxcvbnPhp\Scorer;

/**
 * Class Bruteforce
 * @package ZxcvbnPhp\Matchers
 *
 * Intentionally not named with Match suffix to prevent autoloading from Matcher.
 */
class Bruteforce extends Match
{

    const BRUTEFORCE_CARDINALITY = 10;

    public $pattern = 'bruteforce';

    /**
     * @param string $password
     * @param array $userInputs
     * @return Bruteforce[]
     */
    public static function match($password, array $userInputs = [])
    {
        // Matches entire string.
        $match = new static($password, 0, strlen($password) - 1, $password);
        return [$match];
    }


    public function getFeedback($isSoleMatch)
    {
        return [
            'warning' => "",
            'suggestions' => [
            ]
        ];
    }

    /**
     * @param $password
     * @param $begin
     * @param $end
     * @param $token
     * @param $cardinality
     */
    public function __construct($password, $begin, $end, $token, $cardinality = null)
    {
        parent::__construct($password, $begin, $end, $token);
        // Cardinality can be injected to support full password cardinality instead of token.
        $this->cardinality = $cardinality;
    }

    public function getRawGuesses()
    {
        $guesses = pow(self::BRUTEFORCE_CARDINALITY, strlen($this->token));
        if ($guesses === INF) {
            return defined('PHP_FLOAT_MAX') ? PHP_FLOAT_MAX : 1e308;
        }

        // small detail: make bruteforce matches at minimum one guess bigger than smallest allowed
        // submatch guesses, such that non-bruteforce submatches over the same [i..j] take precedence.
        if (strlen($this->token) === 1) {
            $minGuesses = Scorer::MIN_SUBMATCH_GUESSES_SINGLE_CHAR + 1;
        } else {
            $minGuesses = Scorer::MIN_SUBMATCH_GUESSES_MULTI_CHAR + 1;
        }

        return max($guesses, $minGuesses);
    }
}

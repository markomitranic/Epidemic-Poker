<?php

namespace App\Client;

use Faker\Factory;

final class NameGenerator
{

    /** @var string[] */
    public const AVAILABLE_NAMES = [
        '😀',
        '🤡',
        '👻',
        '👾',
        '🤖',
        '🎃',
        '👮‍',
        '🦁',
        '🐻',
        '🐭',
        '🦊',
        '🐦'
    ];

    private int $nextIndex  = 0;

    public function getRandom(): string {
        if (array_key_exists($this->nextIndex, self::AVAILABLE_NAMES)) {
            $name =  self::AVAILABLE_NAMES[$this->nextIndex];
        } else {
            $name = strtolower((Factory::create())->firstName());
        }
        $this->nextIndex++;
        return $name;
    }

}
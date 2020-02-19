<?php

namespace App\Client;

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
        '🐦',
        '🐶',
        '🐼',
        '🐯',
        '🦁',
        '🐥',
        '🦄'
    ];

    public static function getRandom(): string {
        return self::AVAILABLE_NAMES[array_rand(self::AVAILABLE_NAMES, 1)];
    }

}
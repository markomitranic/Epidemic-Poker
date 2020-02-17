<?php

namespace App\Message;

use App\Message\Auth\Message;

interface Hydrator
{

    public static function handleHydration(array $data): Message;

}
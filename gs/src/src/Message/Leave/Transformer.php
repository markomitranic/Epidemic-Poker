<?php

namespace App\Message\Leave;

use App\Message\Transformer as BaseTransformer;

class Transformer extends BaseTransformer
{

    public function hydrate(array $data): Message
    {
        return new Message($data['payload']['roomId']);
    }

}
<?php

namespace App\Message;

abstract class Transformer
{

    /**
     * @param array $data
     * @return Message
     * @throws \Throwable
     */
    abstract public function hydrate(array $data): Message;

    /**
     * @param Message $message
     * @return array
     * @throws \Throwable
     */
    public function transform(Message $message): array
    {
        return $message->jsonSerialize();
    }

}
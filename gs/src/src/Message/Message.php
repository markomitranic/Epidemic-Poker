<?php

namespace App\Message;

abstract class Message implements \JsonSerializable
{

    protected string $title;

    protected Payload $payload;

    public function __construct(
        string $title,
        Payload $payload
    ) {
        $this->title = $title;
        $this->payload = $payload;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }

    public function setPayload(Payload $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'payload' => $this->getPayload()
        ];
    }
}
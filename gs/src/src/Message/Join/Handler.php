<?php

namespace App\Message\Join;

use App\Message\Error;
use App\Message\ErrorMessage\Message as NotFoundMessage;
use App\Room\RoomRegistry;
use App\Server\Connection\WsConnection;
use App\Utility\Log;

class Handler implements \App\Message\Handler
{

    /** @var string  */
    public const NAME = 'join';

    public function handle(WsConnection $connection, array $data): void
    {
        try {
            $message = $this->convertData($data);
            /** @var Payload $payload */
            $payload = $message->getPayload();
        } catch (\Throwable $e) {
            Log::error(Error::message(Error::PAYLOAD_DESERIALIZE), ['originalMessage' => $data, 'exception' => $e]);
            $connection->send(new NotFoundMessage($data, Error::PAYLOAD_DESERIALIZE));
            return;
        }

        try {
            $room = $this->rooms->getByName($payload->getRoomId());
        } catch (\Exception $e) {
            Log::error(Error::message(Error::NO_ROOM), ['originalMessage' => $data, 'exception' => $e]);
            $connection->send(new NotFoundMessage($data, Error::NO_ROOM));
            return;
        }

    }

    public static function shouldHandle(array $data): bool
    {
        if (array_key_exists('title', $data) && $data['title'] === self::NAME) {
            return true;
        }
        return false;
    }
}
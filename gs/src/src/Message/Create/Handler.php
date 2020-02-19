<?php

namespace App\Message\Create;

use App\Message\Error;
use App\Message\ErrorMessage\Message as ErrorMessage;
use App\Message\InitialState\Message as InitialStateMessage;
use App\Room\RoomClient;
use App\Room\RoomRegistry;
use App\Server\Connection\WsConnection;
use App\Utility\Log;

class Handler implements \App\Message\Handler
{

    /** @var string  */
    public const NAME = 'create';

    private RoomRegistry $rooms;

    public function __construct(RoomRegistry $roomRegistry)
    {
        $this->rooms = $roomRegistry;
    }

    public function handle(WsConnection $connection, array $data): void
    {
        try {
            $message = $this->convertData($data);
            /** @var Payload $payload */
            $payload = $message->getPayload();
        } catch (\Throwable $e) {
            Log::error(Error::message(Error::PAYLOAD_DESERIALIZE), ['originalMessage' => $data, 'exception' => $e]);
            $connection->send(new ErrorMessage($data, Error::PAYLOAD_DESERIALIZE));
            return;
        }

        try {
            $room = $this->rooms->create($payload->getType());
            $roomClient = $room->join($connection->getClient());

            $connection->send(new InitialStateMessage(
                $room->getName(),
                $roomClient->getName(),
                $room->getType(),
                $room->getCurrentRoundIndex(),
                $room->getRounds()
            ));
        } catch (\Exception $e) {
            Log::error(Error::message(Error::ERROR_CREATING_ROOM), ['originalMessage' => $data, 'exception' => $e]);
            $connection->send(new ErrorMessage($data, Error::ERROR_CREATING_ROOM));
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

    /**
     * @param array $data
     * @return Message
     * @throws \Throwable
     */
    private function convertData(array $data): Message
    {
        return (new Transformer())->hydrate($data);
    }
}
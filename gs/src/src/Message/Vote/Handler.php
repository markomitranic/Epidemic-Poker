<?php

namespace App\Message\Vote;

use App\Client\Client;
use App\Message\Error;
use App\Message\ErrorMessage\Message as NotFoundMessage;
use App\Message\VoteChange\Message as VoteChangeMessage;
use App\Room\RoomRegistry;
use App\Room\Vote;
use App\Server\Connection\WsConnection;
use App\Utility\Log;

class Handler implements \App\Message\Handler
{

    /** @var string  */
    public const NAME = 'vote';

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
            $connection->send(new NotFoundMessage($data, Error::PAYLOAD_DESERIALIZE));
            return;
        }

        try {
            $room = $this->rooms->getByName(strtolower($payload->getRoomId()));

            $vote = new Vote($connection->getClient(), $payload->getValue());
            $room->getCurrentRound()->addVote($vote);

            foreach ($room->getClients() as $client) {
                if ($client !== $connection->getClient()) {
                    $this->sendVoteChangeToClient($client, $room->getName(), $vote);
                }
            }
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

    private function sendVoteChangeToClient(Client $client, string $roomName, Vote $vote): void
    {
        if (is_null($client->getConnection())) {
            return;
        }

        $client->getConnection()->send(new VoteChangeMessage(
            $roomName,
            $vote->getValue(),
            $client->getName()
        ));
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
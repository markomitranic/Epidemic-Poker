<?php

namespace App\Message\InitialState;

use App\Message\Message as BaseMessage;
use App\Room\Round;

class Message extends BaseMessage
{

    public const TITLE = 'initialState';

    /**
     * Message constructor.
     * @param string $roomId
     * @param string $clientName
     * @param string $type
     * @param int $currentRound
     * @param Round[] $results
     */
    public function __construct(
        string $roomId,
        string $clientName,
        string $type,
        int $currentRound = 0,
        array $results = []
    ){
        parent::__construct(
            self::TITLE,
            new Payload($roomId, $clientName, $type, $currentRound, $results)
        );
    }

}
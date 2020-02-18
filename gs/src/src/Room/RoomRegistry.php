<?php

namespace App\Room;

use Faker\Factory;

final class RoomRegistry
{

    /**
     * @var Room[]
     */
    private array $rooms = [];

    public function getByName(string $roomName): Room
    {
        foreach ($this->rooms as $room) {
            if ($room->getName() === $roomName) {
                return $room;
            }
        }

        throw new \Exception('No existing rooms found.');
    }

    public function create(string $type): Room
    {
        $faker = Factory::create();

        do {
            $name = strtolower($faker->firstName());
        } while ($this->nameInUse($name));

        $this->rooms[$name] = new Room($name);
        return $this->rooms[$name];
    }

    private function nameInUse(string $name): bool
    {
        if (array_key_exists($name, $this->rooms)) {
            return true;
        }
        return false;
    }


}
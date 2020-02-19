<?php


namespace App\Room;


class Round
{

    /** @var Vote[] */
    private array $votes = [];

    /**
     * @return Vote[]
     */
    public function getVotes(): array
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        foreach ($this->votes as $existingVote) {
            if ($existingVote->getClient() === $vote->getClient()) {
                $existingVote->setValue($vote->getValue());
                return $this;
            }
        }

        $this->votes[] = $vote;
        return $this;
    }

}
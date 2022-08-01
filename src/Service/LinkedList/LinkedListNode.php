<?php
declare(strict_types=1);

namespace App\Service\LinkedList;

class LinkedListNode
{
    public function __construct(
        private string|int $value,
        private LinkedListNode|null $nextNode = null
    ) {
        //
    }

    public function getValue(): string|int
    {
        return $this->value;
    }

    public function getNextNode(): ?LinkedListNode
    {
        return $this->nextNode;
    }

    public function setNextNode(?LinkedListNode $nextNode): static
    {
        $this->nextNode = $nextNode;

        return $this;
    }
}

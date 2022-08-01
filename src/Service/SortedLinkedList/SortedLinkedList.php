<?php
declare(strict_types=1);

namespace App\Service\SortedLinkedList;

use App\Exception\ListService\InvalidValueTypeException;
use App\Exception\ListService\ListCreationException;
use App\Service\LinkedList\LinkedList;
use App\Service\LinkedList\LinkedListNode;
use JetBrains\PhpStorm\ExpectedValues;

class SortedLinkedList extends LinkedList
{
    public const DIRECTION_ASC = 'asc';
    public const DIRECTION_DESC = 'desc';
    public const DIRECTIONS = [
        self::DIRECTION_ASC,
        self::DIRECTION_DESC,
    ];

    private string $direction;

    /**
     * SortedLinkedList constructor.
     *
     * @throws ListCreationException
     * @throws InvalidValueTypeException
     */
    public function __construct(
        array $initialValues = [],
        #[ExpectedValues(self::DIRECTIONS)]
        string $direction = self::DIRECTION_ASC
    ) {
        $this->setDirection($direction);
        parent::__construct($initialValues);
    }

    /**
     * @throws ListCreationException
     */
    protected function addNode(int|string $value): void
    {
        $newNode = new LinkedListNode($value);

        if (is_null($this->head)) {
            $this->head = $newNode;
        } else {
            switch ($this->direction) {
                case self::DIRECTION_ASC:
                    $this->addNodeAsc($newNode);
                    break;
                case self::DIRECTION_DESC:
                    $this->addNodeDesc($newNode);
                    break;
                default:
                    throw new ListCreationException();
            }
        }
    }

    /**
     * @throws ListCreationException
     */
    private function setDirection(string $direction)
    {
        if (!in_array($direction, self::DIRECTIONS)) {
            throw new ListCreationException();
        }
        $this->direction = $direction;
    }

    private function addNodeAsc(LinkedListNode $newNode): void
    {
        if ($this->head->getValue() > $newNode->getValue()) {
            $newNode->setNextNode($this->head);
            $this->head = $newNode;
        } else {
            $currentNode = $this->head;
            while (!empty($currentNode->getNextNode())) {
                if ($currentNode->getNextNode()->getValue() > $newNode->getValue()) {
                    $newNode->setNextNode($currentNode->getNextNode());
                    $currentNode->setNextNode($newNode);

                    return;
                }

                $currentNode = $currentNode->getNextNode();
            }

            $currentNode->setNextNode($newNode);
        }
    }

    private function addNodeDesc(LinkedListNode $newNode): void
    {
        if ($this->head->getValue() < $newNode->getValue()) {
            $newNode->setNextNode($this->head);
            $this->head = $newNode;
        } else {
            $currentNode = $this->head;
            while (!empty($currentNode->getNextNode())) {
                if ($currentNode->getNextNode()->getValue() < $newNode->getValue()) {
                    $newNode->setNextNode($currentNode->getNextNode());
                    $currentNode->setNextNode($newNode);

                    return;
                }

                $currentNode = $currentNode->getNextNode();
            }

            $currentNode->setNextNode($newNode);
        }
    }
}

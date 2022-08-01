<?php
declare(strict_types=1);

namespace App\Service\LinkedList;

use App\Exception\ListService\InvalidValueTypeException;

class LinkedList
{
    protected null|LinkedListNode $head = null;

    /**
     * LinkedList constructor.
     *
     * @throws InvalidValueTypeException
     */
    public function __construct(array $initialValues = [])
    {
        $this->init($initialValues);
    }

    /**
     * @throws InvalidValueTypeException
     */
    public function init(array $initialValues): void
    {
        foreach ($initialValues as $value) {
            $this->add($value);
        }
    }

    /**
     * @throws InvalidValueTypeException
     */
    public function add($value): void
    {
        $this->validateValueType($value);
        $this->addNode($value);
    }

    public function toArray(): array
    {
        if (is_null($this->head)) {
            return [];
        }

        $current = $this->head;
        $result = [$current->getValue()];
        while (!is_null($current->getNextNode())) {
            $current = $current->getNextNode();
            $result[] = $current->getValue();
        }

        return $result;
    }

    /**
     * @throws InvalidValueTypeException
     */
    protected function validateValueType($value): void
    {
        if (!is_int($value) && !is_string($value)) {
            throw new InvalidValueTypeException();
        }
    }

    protected function addNode(int|string $value): void
    {
        $newNode = new LinkedListNode($value);

        if (is_null($this->head)) {
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->getNextNode() != null) {
                $current = $current->getNextNode();
            }
            $current->setNextNode($newNode);
        }
    }
}

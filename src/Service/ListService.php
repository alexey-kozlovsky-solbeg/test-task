<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\LinkedList\LinkedList;
use App\Service\SortedLinkedList\SortedLinkedList;
use JetBrains\PhpStorm\ExpectedValues;

class ListService
{
    public function createLinkedList(array $initialValues): LinkedList
    {
        return new LinkedList($initialValues);
    }

    public function createSortedLinkedList(
        array $initialValues,
        #[ExpectedValues(SortedLinkedList::DIRECTIONS)]
        string $direction,
    ): SortedLinkedList {
        return new SortedLinkedList($initialValues, $direction);
    }
}

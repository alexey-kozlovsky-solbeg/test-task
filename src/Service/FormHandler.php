<?php
declare(strict_types=1);

namespace App\Service;

class FormHandler
{
    public function __construct(private ListService $listService)
    {
        //
    }

    public function handle(array $map, string|int $newValue, string $direction): array
    {
        $prepared = $this->preprocess($map, $newValue);
        $linkedList = $this->listService->createSortedLinkedList($prepared, $direction);

        return $linkedList->toArray();
    }

    private function preprocess(array $map, string|int $newValue): array
    {
        if ($newValue === "") {
            return $map;
        }

        if (!is_int($newValue) && !preg_match('#[^0-9-]+#is', $newValue)) {
            $newValue = (int) $newValue;
        }

        return array_merge($map, [$newValue]);
    }
}

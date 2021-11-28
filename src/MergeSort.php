<?php

declare(strict_types=1);

namespace PhpSorting;

use JetBrains\PhpStorm\Pure;
use LogicException;
use SplQueue;

/** Bottom-up implementation of mergesort sorting algorithm */
class MergeSort implements SortingAlgorithm
{
    protected SplQueue $mergeQueue;

    #[Pure]
    public function __construct()
    {
        $this->mergeQueue = new SplQueue();
    }

    /**
     * @param array<int> $list
     * @return array<int>
     */
    public function sort(array $list): array
    {
        if (! $list) {
            return [];
        }

        $mergeQueue = $this->enqueueListValues($list);

        $sortedList = $this->mergeSortLists($mergeQueue);

        return array_values($sortedList);
    }

    /**
     * @param array<int, int> $unsortedList [int $index => int $value]
     * @return SplQueue
     */
    protected function enqueueListValues(array $unsortedList): SplQueue
    {
        self::throwIfQueueNotEmpty($this->mergeQueue);

        foreach ($unsortedList as $idx => $val) {
            $this->mergeQueue->enqueue([$idx => $val]);
        }

        return $this->mergeQueue;
    }

    /**
     * Sort an array in ascending order and maintain index association
     *
     * @param SplQueue $mergeQueue
     * @return array<int, int> [int $index => int $value]
     */
    protected function mergeSortLists(SplQueue $mergeQueue): array
    {
        while ($mergeQueue->count() > 1) {
            $listA = $mergeQueue->dequeue();
            $listB = $mergeQueue->dequeue();

            $mergeList = [];

            foreach ($listA as $idxA => $valA) {
                foreach ($listB as $idxB => $valB) {
                    if ($valA < $valB) {
                        $mergeList[$idxA] = $valA;
                        unset($listA[$idxA]);
                        continue 2;
                    }

                    $mergeList[$idxB] = $valB;
                    unset($listB[$idxB]);
                }
            }

            // append leftover values to the end of the mergesort result list

            if ($listA) {
                $mergeList += $listA;
            } elseif ($listB) {
                $mergeList += $listB;
            }

            $mergeQueue->enqueue($mergeList);
        }

        return $mergeQueue->dequeue();
    }

    protected static function throwIfQueueNotEmpty(SplQueue $mergeQueue): void
    {
        if (! $mergeQueue->isEmpty()) {
            throw new LogicException('Merge queue must be empty at the beginning of the algorithm.');
        }
    }
}

<?php

declare(strict_types=1);

namespace PhpSorting;

use Generator;

class BubbleSort implements SortingAlgorithm
{
    /**
     * @param array<int> $list
     * @return array<int>
     */
    public function sort(array $list): array
    {
        $unsortedPositions = count($list);

        while ($unsortedPositions > 1) {
            $values = $this->getValuesIterator($list, $unsortedPositions);

            $val1 = $values->current();
            $key1 = $values->key();

            $values->next();

            while ($values->valid()) {
                $val2 = $values->current();
                $key2 = $values->key();

                if ($val1 > $val2) {
                    $list[$key1] = $val2;
                    $list[$key2] = $val1;
                } else {
                    $val1 = $val2;
                }

                $key1 = $key2;

                $values->next();
            }

            $unsortedPositions--;
        }

        return $list;
    }

    /**
     * @param array<int, int> $list [int $index => int $value]
     * @param int $unsortedPositions
     * @return Generator
     */
    private function getValuesIterator(array $list, int $unsortedPositions): Generator
    {
        foreach ($list as $idx => $value) {
            yield $idx => $value;

            if (--$unsortedPositions === 0) {
                return;
            }
        }
    }
}

<?php

namespace PhpSorting;

interface SortingAlgorithm
{
    /**
     * @param array<int> $list
     * @return array<int>
     */
    public function sort(array $list): array;
}
<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class FilterMutator extends Mutator
{
    /**
     * Iterates over elements of a collection, returning an array of all elements the callback returns truey for.
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        return $this->copyCollectionWith($collection, array_filter(
            $collection->toArray(),
            $iterator
        ));
    }
}

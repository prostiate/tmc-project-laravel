<?php

namespace App\Helpers;

use ArrayObject;
use FilterIterator;

class SpecialFilter extends FilterIterator
{
    private $f;

    public function __construct(array $items, $filter)
    {
        $object = new ArrayObject($items);
        $this->f = $filter;
        parent::__construct($object->getIterator());
    }

    public function accept()
    {
        return 0 === strpos($this->getInnerIterator()->key(), $this->f);
    }
}

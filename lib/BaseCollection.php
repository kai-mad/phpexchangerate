<?php declare(strict_types=1);

namespace CliExchangeRate;

use ArrayObject;
use ArrayIterator;

abstract class BaseCollection extends ArrayObject {
    protected $values;
    
    public function toArray() : array {
        return $this->values;
    }
    
    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->values);
    }
}
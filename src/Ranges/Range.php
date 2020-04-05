<?php

namespace Belamov\PostrgesRange\Ranges;

abstract class Range
{
    protected string $fromBound;
    protected string $toBound;

    abstract public function from();
    abstract public function to();
    abstract public function __toString();
}

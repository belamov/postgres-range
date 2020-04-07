<?php

namespace Belamov\PostgresRange\Ranges;

use DateTimeInterface;

trait StringifiesBoundariesFromDateTimeInterface
{
    /**
     * @param  DateTimeInterface|string|null  $from
     * @param  DateTimeInterface|string|null  $to
     * @param  string  $fromBound
     * @param  string  $toBound
     */
    public function __construct($from = null, $to = null, $fromBound = '[', $toBound = ')')
    {
        $from = $this->stringifyBoundary($from);
        $to = $this->stringifyBoundary($to);

        parent::__construct($from, $to, $fromBound, $toBound);
    }

    /**
     * @param $boundary
     * @return string|null
     */
    protected function stringifyBoundary($boundary): ?string
    {
        if ($boundary instanceof DateTimeInterface) {
            return $boundary->format($this->getBoundaryFormat());
        }

        return $boundary;
    }

    /**
     * @return string
     */
    abstract protected function getBoundaryFormat(): string;
}
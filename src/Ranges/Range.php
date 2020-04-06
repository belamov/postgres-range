<?php

namespace Belamov\PostrgesRange\Ranges;

/**
 * Class Range
 *
 * @property string $fromBound
 * @property string $toBound
 *
 * @package Belamov\PostrgesRange\Ranges
 */
abstract class Range
{
    protected string $fromBound;
    protected string $toBound;
    protected ?string $from;
    protected ?string $to;

    public function __construct(string $from = null, string $to = null, $fromBound = '[', $toBound = ')')
    {
        $this->from = $from;
        $this->to = $to;
        $this->fromBound = $fromBound;
        $this->toBound = $toBound;
    }

    /**
     * @return mixed
     */
    public function from()
    {
        if ($this->from === null) {
            return null;
        }

        return $this->transformBoundary($this->from);
    }

    /**
     * @param  string  $boundary
     * @return mixed
     */
    abstract protected function transformBoundary(string $boundary);

    /**
     * @return mixed
     */
    public function to()
    {
        if ($this->to === null) {
            return null;
        }

        return $this->transformBoundary($this->to);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->fromBound}{$this->from},{$this->to}{$this->toBound}";
    }
}

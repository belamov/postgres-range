<?php

namespace Belamov\PostgresRange\Ranges;

abstract class Range
{
    protected string $fromBound;
    protected string $toBound;
    protected ?string $from;
    protected ?string $to;

    public function __construct(?string $from = null, ?string $to = null, string $fromBound = '[', string $toBound = ')')
    {
        $this->from = $from;
        $this->to = $to;
        $this->fromBound = $fromBound;
        $this->toBound = $toBound;

        $this->checkForEmptyBoundaries();
    }

    /**
     * @return mixed
     */
    public function from()
    {
        if ($this->from === null) {
            return;
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
            return;
        }

        return $this->transformBoundary($this->to);
    }

    public function hasLowerBoundary(): bool
    {
        return $this->from !== null;
    }

    public function hasUpperBoundary(): bool
    {
        return $this->to !== null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->fromBound}{$this->from},{$this->to}{$this->toBound}";
    }

    /**
     * @return string
     */
    abstract public function forSql(): string;

    private function checkForEmptyBoundaries(): void
    {
        if ($this->to === '') {
            $this->to = null;
        }
        if ($this->from === '') {
            $this->from = null;
        }
    }

    public function fromBound(): string
    {
        return $this->fromBound;
    }

    public function toBound(): string
    {
        return $this->toBound;
    }
}

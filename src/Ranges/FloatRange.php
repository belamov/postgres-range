<?php

namespace Belamov\PostrgesRange\Ranges;

class FloatRange extends Range
{
    private ?float $from;
    private ?float $to;

    /**
     * @param float|null $from
     * @param float|null $to
     * @param string $fromBound
     * @param string $toBound
     */
    public function __construct(float $from = null, float $to = null, $fromBound = '[', $toBound = ')')
    {
        $this->from = $from;
        $this->to = $to;
        $this->fromBound = $fromBound;
        $this->toBound = $toBound;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $to = $this->to() ?? '';
        $from = $this->from() ?? '';

        return "{$this->fromBound}{$from},{$to}{$this->toBound}";
    }

    /**
     * @return float|null
     */
    public function to(): ?float
    {
        return $this->to;
    }

    /**
     * @return float|null
     */
    public function from(): ?float
    {
        return $this->from;
    }
}

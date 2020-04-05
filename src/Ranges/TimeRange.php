<?php

namespace Belamov\PostrgesRange\Ranges;

class TimeRange extends Range
{
    private ?string $from;
    private ?string $to;

    /**
     * @param string|null $from
     * @param string|null $to
     * @param string $fromBound
     * @param string $toBound
     */
    public function __construct(string $from = null, string $to = null, $fromBound = '[', $toBound = ')')
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
     * @return string|null
     */
    public function to(): ?string
    {
        return $this->to;
    }

    /**
     * @return string|null
     */
    public function from(): ?string
    {
        return $this->from;
    }
}

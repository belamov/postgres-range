<?php

namespace Belamov\PostrgesRange\Ranges;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class TimestampRange extends Range
{
    private ?CarbonInterface $from;
    private ?CarbonInterface $to;

    /**
     * @param string|null $from
     * @param string|null $to
     * @param string $fromBound
     * @param string $toBound
     */
    public function __construct(string $from = null, string $to = null, $fromBound = '[', $toBound = ')')
    {
        // for some reason when range column is fetched, its boundaries are surrounded with double quotes
        $this->from = $from ? CarbonImmutable::parse(str_replace('"', '', $from)) : null;
        $this->to = $to ? CarbonImmutable::parse(str_replace('"', '', $to)) : null;
        $this->fromBound = $fromBound;
        $this->toBound = $toBound;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $to = $this->to() ? $this->to()->toDateTimeString() : '';
        $from = $this->from() ? $this->from()->toDateTimeString() : '';

        return "{$this->fromBound}{$from},{$to}{$this->toBound}";
    }

    /**
     * @return CarbonInterface|null
     */
    public function to(): ?CarbonInterface
    {
        return $this->to;
    }

    /**
     * @return CarbonInterface|null
     */
    public function from(): ?CarbonInterface
    {
        return $this->from;
    }
}

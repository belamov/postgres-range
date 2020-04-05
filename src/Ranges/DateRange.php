<?php

namespace Belamov\PostrgesRange\Ranges;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class DateRange extends Range
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

        // The built-in range types int4range, int8range, and daterange all use a canonical form
        // that includes the lower bound and excludes the upper bound; that is, [)
        if ($fromBound === '(') {
            if ($this->from !== null) {
                $this->from = $this->from->addDay();
            }
            $this->fromBound = '[';
        }

        if ($toBound === ']') {
            if ($this->to !== null) {
                $this->to = $this->to->addDay();
            }
            $this->toBound = ')';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $to = $this->to() ? $this->to()->toDateString() : '';
        $from = $this->from() ? $this->from()->toDateString() : '';

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

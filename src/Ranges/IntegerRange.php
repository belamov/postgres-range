<?php

namespace Belamov\PostrgesRange\Ranges;

class IntegerRange extends Range
{
    private ?int $from;
    private ?int $to;

    /**
     * @param int|null $from
     * @param int|null $to
     * @param string $fromBound
     * @param string $toBound
     */
    public function __construct(int $from = null, int $to = null, $fromBound = '[', $toBound = ')')
    {
        $this->from = $from;
        $this->to = $to;

        $this->fromBound = $fromBound;
        $this->toBound = $toBound;

        // The built-in range types int4range, int8range, and daterange all use a canonical form
        // that includes the lower bound and excludes the upper bound; that is, [)
        if ($fromBound === '(') {
            if ($this->from !== null) {
                $this->from++;
            }
            $this->fromBound = '[';
        }

        if ($toBound === ']') {
            if ($this->to !== null) {
                $this->to++;
            }
            $this->toBound = ')';
        }
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
     * @return int|null
     */
    public function to(): ?int
    {
        return $this->to;
    }

    /**
     * @return int|null
     */
    public function from(): ?int
    {
        return $this->from;
    }
}

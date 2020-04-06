<?php

namespace Belamov\PostrgesRange\Ranges;

/**
 * Class CanonicalRange
 *
 * Range that automatically canonicalizes its boundary to [)
 *
 * @package Belamov\PostrgesRange\Ranges
 */
abstract class CanonicalRange extends Range
{
    public function __construct(string $from = null, string $to = null, $fromBound = '[', $toBound = ')')
    {
        parent::__construct($from, $to, $fromBound, $toBound);
        $this->canonicalizeBoundaries();
    }

    /**
     * The built-in range types int4range, int8range, and daterange all use a canonical form
     * that includes the lower bound and excludes the upper bound; that is, [)
     */
    private function canonicalizeBoundaries(): void
    {
        $this->canonicalizeLowerBoundary();
        $this->canonicalizeUpperBoundary();
    }

    private function canonicalizeLowerBoundary(): void
    {
        if ($this->fromBound === '(') {
            if ($this->from !== null) {
                $this->from = $this->addToDiscreteBoundary($this->from);
            }
            $this->fromBound = '[';
        }
    }

    /**
     * @param $boundary
     * @return string
     */
    abstract protected function addToDiscreteBoundary($boundary): string;

    private function canonicalizeUpperBoundary(): void
    {
        if ($this->toBound === ']') {
            if ($this->to !== null) {
                $this->to = $this->addToDiscreteBoundary($this->to);
            }
            $this->toBound = ')';
        }
    }
}
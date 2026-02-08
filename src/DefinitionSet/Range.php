<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 * @internal
 */
final class Range implements Implementation
{
    private function __construct(
        private bool $lowerInclusivity,
        private Number $lower,
        private Number $upper,
        private bool $upperInclusivity,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function inclusive(Number $lower, Number $upper): self
    {
        return new self(true, $lower, $upper, true);
    }

    /**
     * @psalm-pure
     */
    public static function exclusive(Number $lower, Number $upper): self
    {
        return new self(false, $lower, $upper, false);
    }

    #[\Override]
    public function contains(Number $number): bool
    {
        if ($this->lower->higherThan($number)) {
            return false;
        }

        if ($number->higherThan($this->upper)) {
            return false;
        }

        if (
            !$this->lowerInclusivity &&
            $this->lower->equals($number)
        ) {
            return false;
        }

        if (
            !$this->upperInclusivity &&
            $this->upper->equals($number)
        ) {
            return false;
        }

        return true;
    }

    #[\Override]
    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf(
            '%s%s;%s%s',
            $this->lowerInclusivity ? '[' : ']',
            $this->lower->toString(),
            $this->upper->toString(),
            $this->upperInclusivity ? ']' : '[',
        );
    }
}

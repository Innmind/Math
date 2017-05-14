<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\NumberInterface;

final class Range implements SetInterface
{
    public const INCLUSIVE = true;
    public const EXCLUSIVE = false;

    private $lowerInclusivity;
    private $upperInclusivity;
    private $lower;
    private $upper;

    public function __construct(
        bool $lowerInclusivity,
        NumberInterface $lower,
        NumberInterface $upper,
        bool $upperInclusivity
    ) {
        $this->lowerInclusivity = $lowerInclusivity;
        $this->lower = $lower;
        $this->upper = $upper;
        $this->upperInclusivity = $upperInclusivity;
    }

    public static function inclusive(
        NumberInterface $lower,
        NumberInterface $upper
    ): self {
        return new self(self::INCLUSIVE, $lower, $upper, self::INCLUSIVE);
    }

    public static function exclusive(
        NumberInterface $lower,
        NumberInterface $upper
    ): self {
        return new self(self::EXCLUSIVE, $lower, $upper, self::EXCLUSIVE);
    }

    public function contains(NumberInterface $number): bool
    {
        if ($this->lower->higherThan($number)) {
            return false;
        }

        if ($number->higherThan($this->upper)) {
            return false;
        }

        if (
            $this->lowerInclusivity === self::EXCLUSIVE &&
            $this->lower->equals($number)
        ) {
            return false;
        }

        if (
            $this->upperInclusivity === self::EXCLUSIVE &&
            $this->upper->equals($number)
        ) {
            return false;
        }

        return true;
    }

    public function union(SetInterface $set): SetInterface
    {
        return new Union($this, $set);
    }

    public function intersect(SetInterface $set): SetInterface
    {
        return new Intersection($this, $set);
    }

    public function __toString(): string
    {
        return sprintf(
            '%s%s;%s%s',
            $this->lowerInclusivity === self::INCLUSIVE ? '[' : ']',
            $this->lower,
            $this->upper,
            $this->upperInclusivity === self::INCLUSIVE ? ']' : '['
        );
    }
}

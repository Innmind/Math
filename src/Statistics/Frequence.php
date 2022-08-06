<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Division,
};
use Innmind\Immutable\Sequence;

final class Frequence
{
    /** @var Sequence<Number> */
    private Sequence $values;
    private Number $size;

    /**
     * @no-named-arguments
     */
    public function __construct(Number ...$values)
    {
        $this->values = Sequence::of(...$values);
        $this->size = new Number\Number($this->values->size());
    }

    public function __invoke(Number $number): Number
    {
        $frequence = $this
            ->values
            ->filter(static function(Number $value) use ($number): bool {
                return $value->equals($number);
            })
            ->size();

        return new Division(new Number\Number($frequence), $this->size);
    }

    public function size(): Number
    {
        return $this->size;
    }
}

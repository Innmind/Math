<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\subtract;
use Innmind\Math\Algebra\NumberInterface;

final class Integral
{
    private $polynom;

    public function __construct(Polynom $polynom)
    {
        $this->polynom = $polynom;
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function __invoke(NumberInterface $a, NumberInterface $b): NumberInterface
    {
        $primitive = $this->polynom->primitive();

        return subtract($primitive($b), $primitive($a));
    }

    public function __toString(): string
    {
        return sprintf(
            '∫(%s)dx = [%s]',
            $this->polynom,
            $this->polynom->primitive()
        );
    }
}

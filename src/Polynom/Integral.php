<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\subtract;
use Innmind\Math\Algebra\Number;

final class Integral
{
    private Polynom $polynom;

    public function __construct(Polynom $polynom)
    {
        $this->polynom = $polynom;
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function __invoke(Number $a, Number $b): Number
    {
        $primitive = $this->polynom->primitive();

        return subtract($primitive($b), $primitive($a));
    }

    public function toString(): string
    {
        return \sprintf(
            '∫(%s)dx = [%s]',
            $this->polynom->toString(),
            $this->polynom->primitive()->toString(),
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\subtract;
use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Integral
{
    private Polynom $polynom;

    private function __construct(Polynom $polynom)
    {
        $this->polynom = $polynom;
    }

    public function __invoke(Number $a, Number $b): Number
    {
        $primitive = $this->polynom->primitive();

        return subtract($primitive($b), $primitive($a));
    }

    /**
     * @psalm-pure
     */
    public static function of(Polynom $polynom): self
    {
        return new self($polynom);
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
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

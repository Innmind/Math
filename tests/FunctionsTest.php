<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math;

use function Innmind\Math\{
    max as maximum,
    min as minimum,
};
use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function testMax()
    {
        $number = maximum(
            Number::of(1),
            Number::of(2),
            $expected = Number::of(4),
            Number::of(3),
        );

        $this->assertSame($expected, $number);
    }

    public function testMin()
    {
        $number = minimum(
            Number::of(2),
            $expected = Number::of(1),
            Number::of(4),
            Number::of(3),
        );

        $this->assertSame($expected, $number);
    }
}

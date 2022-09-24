<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math;

use function Innmind\Math\{
    max as maximum,
    min as minimum,
};
use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Algebra\Real,
};
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function testMax()
    {
        $number = maximum(
            Real::of(1),
            Real::of(2),
            $expected = Real::of(4),
            Real::of(3),
        );

        $this->assertSame($expected, $number);
    }

    public function testMin()
    {
        $number = minimum(
            Real::of(2),
            $expected = Real::of(1),
            Real::of(4),
            Real::of(3),
        );

        $this->assertSame($expected, $number);
    }
}

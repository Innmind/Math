<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use Innmind\Math\{
    Probabilities\Variance,
    Regression\Dataset,
    Algebra\Number
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class VarianceTest extends TestCase
{
    public function testInvokation()
    {
        $variance = Variance::of(
            Dataset::of([
                [-1, 4/6],
                [2, 1/6],
                [3, 1/6],
            ]),
        );

        $this->assertInstanceOf(Number::class, $variance());
        $this->assertSame(
            101/36,
            $variance()->value(),
        );
    }
}

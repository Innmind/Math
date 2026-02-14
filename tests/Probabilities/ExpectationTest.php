<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use Innmind\Math\{
    Probabilities\Expectation,
    Regression\Dataset,
    Algebra\Number
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExpectationTest extends TestCase
{
    public function testInvokation()
    {
        $expectation = Expectation::of(
            Dataset::of([
                [-1, 4/6],
                [2, 1/6],
                [3, 1/6],
            ]),
        );

        $this->assertInstanceOf(Number::class, $expectation());
        $this->assertEqualsWithDelta(
            1/6,
            $expectation()->value(),
            0.00001,
        );
    }

    private function assertEqualsWithDelta(
        int|float $expected,
        int|float $value,
        int|float $delta,
    ): void {
        $this->assertGreaterThanOrEqual($expected-$delta, $value);
        $this->assertLessThanOrEqual($expected+$delta, $value);
    }
}

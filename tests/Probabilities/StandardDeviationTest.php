<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use Innmind\Math\{
    Probabilities\StandardDeviation,
    Regression\Dataset,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class StandardDeviationTest extends TestCase
{
    public function testInvokation()
    {
        $deviation = StandardDeviation::of(
            Dataset::of([
                [-1, 4/6],
                [2, 1/6],
                [3, 1/6],
            ]),
        );

        $this->assertInstanceOf(Number::class, $deviation());
        $this->assertSame(
            \sqrt(101/36),
            $deviation()->value(),
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use function Innmind\Math\divide;
use Innmind\Math\{
    Probabilities\Variance,
    Regression\Dataset,
    Algebra\NumberInterface
};
use PHPUnit\Framework\TestCase;

class VarianceTest extends TestCase
{
    public function testInvokation()
    {
        $variance = new Variance(
            Dataset::fromArray([
                [-1, divide(4, 6)],
                [2, divide(1, 6)],
                [3, divide(1, 6)],
            ])
        );

        $this->assertInstanceOf(NumberInterface::class, $variance());
        $this->assertSame(
            divide(101, 36)->value(),
            $variance()->value()
        );
    }
}
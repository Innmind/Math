<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use function Innmind\Math\divide;
use Innmind\Math\{
    Probabilities\StandardDeviation,
    Regression\Dataset,
    Algebra\NumberInterface
};
use PHPUnit\Framework\TestCase;

class StandardDeviationTest extends TestCase
{
    public function testInvokation()
    {
        $deviation = new StandardDeviation(
            Dataset::fromArray([
                [-1, divide(4, 6)],
                [2, divide(1, 6)],
                [3, divide(1, 6)],
            ])
        );

        $this->assertInstanceOf(NumberInterface::class, $deviation());
        $this->assertSame(
            divide(101, 36)->squareRoot()->value(),
            $deviation()->value()
        );
    }
}

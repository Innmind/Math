<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use function Innmind\Math\divide;
use Innmind\Math\{
    Probabilities\Expectation,
    Regression\Dataset,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ExpectationTest extends TestCase
{
    public function testInvokation()
    {
        $expectation = new Expectation(
            Dataset::of([
                [-1, divide(4, 6)],
                [2, divide(1, 6)],
                [3, divide(1, 6)],
            ]),
        );

        $this->assertInstanceOf(Number::class, $expectation());
        $this->assertSame(
            divide(1, 6)->value(),
            $expectation()->value(),
        );
    }
}

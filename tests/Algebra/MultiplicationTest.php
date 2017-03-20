<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Multiplication,
    Number
};
use PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
{
    public function testResult()
    {
        $multiplication = new Multiplication(
            new Number(42),
            new Number(24)
        );
        $result = $multiplication->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(1008, $result->value());
    }

    public function testStringCast()
    {
        $multiplication = new Multiplication(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertSame('24 x 42 x 66', (string) $multiplication);
    }

    /**
     * @expectedException Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException
     */
    public function testThrowWhenNotEnoughNumbers()
    {
        new Multiplication(new Number(42));
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Subtraction,
    Number,
    OperationInterface
};
use PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
{
    public function testInterface()
    {
        $subtraction = new Subtraction(
            new Number(4),
            new Number(2)
        );

        $this->assertInstanceOf(OperationInterface::class, $subtraction);
    }

    public function testResult()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );
        $result = $subtraction->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(18, $result->value());
    }

    public function testStringCast()
    {
        $subtraction = new Subtraction(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertSame('24 - 42 - 66', (string) $subtraction);
    }

    /**
     * @expectedException Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException
     */
    public function testThrowWhenNotEnoughNumbers()
    {
        new Subtraction(new Number(42));
    }
}

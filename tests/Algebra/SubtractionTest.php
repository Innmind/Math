<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Subtraction,
    Number,
    OperationInterface,
    NumberInterface,
    Addition
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
        $this->assertInstanceOf(NumberInterface::class, $subtraction);
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

    public function testValue()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );

        $this->assertSame(18, $subtraction->value());
    }

    public function testEquals()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );

        $this->assertTrue($subtraction->equals(new Number(18)));
        $this->assertFalse($subtraction->equals(new Number(18.1)));
    }

    public function testHigherThan()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );

        $this->assertFalse($subtraction->higherThan(new Number(18)));
        $this->assertTrue($subtraction->higherThan(new Number(17.9)));
    }

    public function testStringCast()
    {
        $subtraction = new Subtraction(
            new Addition(
                new Number(12),
                new Number(12)
            ),
            new Number(42),
            new Number(66)
        );

        $this->assertSame('(12 + 12) - 42 - 66', (string) $subtraction);
    }

    /**
     * @expectedException Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException
     */
    public function testThrowWhenNotEnoughNumbers()
    {
        new Subtraction(new Number(42));
    }
}

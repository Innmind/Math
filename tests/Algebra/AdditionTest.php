<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Addition,
    Number,
    OperationInterface,
    NumberInterface
};
use PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    public function testInterface()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertInstanceOf(OperationInterface::class, $addition);
        $this->assertInstanceOf(NumberInterface::class, $addition);
    }

    public function testResult()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );
        $result = $addition->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(132, $result->value());
    }

    public function testValue()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertSame(132, $addition->value());
    }

    public function testEquals()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertTrue($addition->equals(new Number(132)));
        $this->assertFalse($addition->equals(new Number(131)));
    }

    public function testStringCast()
    {
        $addition = new Addition(
            new Number(24),
            new Addition(
                new Number(42),
                new Number(66)
            )
        );

        $this->assertSame('24 + (42 + 66)', (string) $addition);
    }

    /**
     * @expectedException Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException
     */
    public function testThrowWhenNotEnoughNumbers()
    {
        new Addition(new Number(42));
    }
}

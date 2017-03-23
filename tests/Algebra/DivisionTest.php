<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Division,
    Number,
    OperationInterface,
    NumberInterface,
    Addition
};
use PHPUnit\Framework\TestCase;

class DivisionTest extends TestCase
{
    public function testInterface()
    {
        $division = new Division(
            $dividend = new Number(4),
            $divisor = new Number(2)
        );

        $this->assertInstanceOf(OperationInterface::class, $division);
        $this->assertInstanceOf(NumberInterface::class, $division);
        $this->assertSame($dividend, $division->dividend());
        $this->assertSame($divisor, $division->divisor());
    }

    public function testResult()
    {
        $division = new Division(new Number(4), new Number(2));
        $result = $division->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2, $result->value());
    }

    public function testValue()
    {
        $division = new Division(new Number(4), new Number(2));

        $this->assertSame(2, $division->value());
    }

    public function testEquals()
    {
        $division = new Division(new Number(4), new Number(2));

        $this->assertTrue($division->equals(new Number(2)));
        $this->assertFalse($division->equals(new Number(2.1)));
    }

    public function testHigherThan()
    {
        $division = new Division(new Number(4), new Number(2));

        $this->assertFalse($division->higherThan(new Number(2)));
        $this->assertTrue($division->higherThan(new Number(1.9)));
    }

    public function testStringCast()
    {
        $this->assertSame(
            '(2 + 2) ÷ 2',
            (string) new Division(
                new Addition(
                    new Number(2),
                    new Number(2)
                ),
                new Number(2)
            )
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\DivisionByZeroError
     */
    public function testThrowWhenTryingToDivideByZero()
    {
        new Division(new Number(4), new Number(0));
    }
}

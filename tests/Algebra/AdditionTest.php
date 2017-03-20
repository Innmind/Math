<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Addition,
    Number
};
use PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
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

    public function testStringCast()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertSame('24 + 42 + 66', (string) $addition);
    }

    /**
     * @expectedException Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException
     */
    public function testThrowWhenNotEnoughNumbers()
    {
        new Addition(new Number(42));
    }
}

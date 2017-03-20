<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Number,
    NumberInterface
};
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            NumberInterface::class,
            new Number(42)
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\TypeError
     * @expectedExceptionMessage Number must be an int or a float
     */
    public function testThrowWhenValueNotAnIntNorAFloat()
    {
        new Number('42');
    }

    public function testInt()
    {
        $number = new Number(42);

        $this->assertSame(42, $number->value());
        $this->assertSame('42', (string) $number);
    }

    public function testFloat()
    {
        $number = new Number(42.24);

        $this->assertSame(42.24, $number->value());
        $this->assertSame('42.24', (string) $number);
    }

    public function testEquals()
    {
        $this->assertTrue((new Number(42))->equals(new Number(42)));
        $this->assertFalse((new Number(42))->equals(new Number(42.24)));
    }
}

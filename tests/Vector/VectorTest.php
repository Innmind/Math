<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Vector;

use Innmind\Math\Vector\Vector;
use PHPUnit\Framework\TestCase;

class VectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = new Vector(1, 2, 3);

        $this->assertSame([1.0, 2.0, 3.0], $vector->toArray());
        $this->assertInstanceOf(\Iterator::class, $vector);
        $this->assertSame(3, $vector->dimension());
        $this->assertSame(1.0, $vector->get(0));
        $this->assertSame(2.0, $vector->get(1));
        $this->assertSame(3.0, $vector->get(2));
    }

    public function testDot()
    {
        $number = (new Vector(-1, 2))->dot(new Vector(4, 1));

        $this->assertSame(-2.0, $number);
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowForDotProductWithDifferentDimensions()
    {
        (new Vector(-1, 2))->dot(new Vector(4, 1, 0));
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorCannotBeEmptyException
     */
    public function testThrowWhenEmptyVector()
    {
        new Vector;
    }

    public function testMultiply()
    {
        $vector = new Vector(25, 5, 1);
        $vector2 = $vector->multiply(Vector::initialize(3, 2.56));

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertSame([25.0, 5.0, 1.0], $vector->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $vector2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        Vector::initialize(1, 1)->multiply(Vector::initialize(2, 1));
    }

    public function testDivide()
    {
        $vector = new Vector(25, 5, 1);
        $vector2 = $vector->divide(Vector::initialize(3, 5));

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertSame([25.0, 5.0, 1.0], $vector->toArray());
        $this->assertSame([5.0, 1.0, 0.2], $vector2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenDevidingVectorsOfDifferentDimensions()
    {
        Vector::initialize(1, 1)->divide(Vector::initialize(2, 1));
    }

    public function testInitialize()
    {
        $vector = Vector::initialize(4, 1.2);

        $this->assertInstanceOf(Vector::class, $vector);
        $this->assertSame([1.2, 1.2, 1.2, 1.2], $vector->toArray());
    }

    public function testSubtract()
    {
        $vector1 = new Vector(1, 2, 3, 4);
        $vector2 = new Vector(0.5, 2.5, 2.8, 4.2);

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(Vector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [0.5, -0.5, 0.2, -0.2],
            $vector3->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        Vector::initialize(1, 1)->subtract(Vector::initialize(2, 1));
    }

    public function testAdd()
    {
        $vector1 = new Vector(1, 2, 3, 4);
        $vector2 = new Vector(0.5, 2.5, 2.8, 4.2);

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(Vector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [1.5, 4.5, 5.8, 8.2],
            $vector3->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        Vector::initialize(1, 1)->add(Vector::initialize(2, 1));
    }

    public function testPower()
    {
        $vector1 = new Vector(1, 2, 3, -4);

        $vector2 = $vector1->power(3);

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertEquals(
            [1.0, 8.0, 27.0, -64.0],
            $vector2->toArray()
        );
    }

    public function testSum()
    {
        $vector = new Vector(1, 2, 3, -4);

        $this->assertSame(2.0, $vector->sum());
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\Vector,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class VectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = new Vector(...numerize(1, 2, 3));

        $this->assertCount(3, $vector->toArray());
        $this->assertInstanceOf(\Iterator::class, $vector);
        $this->assertSame(3, $vector->dimension()->value());
        $this->assertInstanceOf(NumberInterface::class, $vector->get(0));
        $this->assertInstanceOf(NumberInterface::class, $vector->get(1));
        $this->assertInstanceOf(NumberInterface::class, $vector->get(2));
        $this->assertSame(1, $vector->get(0)->value());
        $this->assertSame(2, $vector->get(1)->value());
        $this->assertSame(3, $vector->get(2)->value());
        $this->assertSame([1, 2, 3], $vector->toArray());
    }

    public function testDot()
    {
        $number = (new Vector(...numerize(-1, 2)))->dot(
            new Vector(...numerize(4, 1))
        );

        $this->assertInstanceOf(NumberInterface::class, $number);
        $this->assertSame(-2, $number->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowForDotProductWithDifferentDimensions()
    {
        (new Vector(...numerize(-1, 2)))->dot(
            new Vector(...numerize(4, 1, 0))
        );
    }

    public function testMultiply()
    {
        $vector = new Vector(...numerize(25, 5, 1));
        $vector2 = $vector->multiply(
            Vector::initialize(new Integer(3), new Number(2.56))
        );

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertSame(25, $vector->get(0)->value());
        $this->assertSame(5, $vector->get(1)->value());
        $this->assertSame(1, $vector->get(2)->value());
        $this->assertSame(64.0, $vector2->get(0)->value());
        $this->assertSame(12.8, $vector2->get(1)->value());
        $this->assertSame(2.56, $vector2->get(2)->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        Vector::initialize(new Integer(1), new Number(1))->multiply(
            Vector::initialize(new Integer(2), new Number(1))
        );
    }

    public function testDivide()
    {
        $vector = new Vector(...numerize(25, 5, 1));
        $vector2 = $vector->divide(
            Vector::initialize(new Integer(3), new Number(5))
        );

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertSame(25, $vector->get(0)->value());
        $this->assertSame(5, $vector->get(1)->value());
        $this->assertSame(1, $vector->get(2)->value());
        $this->assertSame(5, $vector2->get(0)->value());
        $this->assertSame(1, $vector2->get(1)->value());
        $this->assertSame(0.2, $vector2->get(2)->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenDevidingVectorsOfDifferentDimensions()
    {
        Vector::initialize(new Integer(1), new Number(1))->divide(
            Vector::initialize(new Integer(2), new Number(1))
        );
    }

    public function testInitialize()
    {
        $vector = Vector::initialize(new Integer(4), new Number(1.2));

        $this->assertInstanceOf(Vector::class, $vector);
        $this->assertSame(1.2, $vector->get(0)->value());
        $this->assertSame(1.2, $vector->get(1)->value());
        $this->assertSame(1.2, $vector->get(2)->value());
        $this->assertSame(1.2, $vector->get(3)->value());
    }

    public function testSubtract()
    {
        $vector1 = new Vector(...numerize(1, 2, 3, 4));
        $vector2 = new Vector(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(Vector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertSame(0.5, $vector3->get(0)->value());
        $this->assertSame(-0.5, $vector3->get(1)->value());
        $this->assertSame(0.2, $vector3->get(2)->value());
        $this->assertSame(-0.2, $vector3->get(3)->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        Vector::initialize(new Integer(1), new Number(1))->subtract(
            Vector::initialize(new Integer(2), new Number(1))
        );
    }

    public function testAdd()
    {
        $vector1 = new Vector(...numerize(1, 2, 3, 4));
        $vector2 = new Vector(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(Vector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertSame(1.5, $vector3->get(0)->value());
        $this->assertSame(4.5, $vector3->get(1)->value());
        $this->assertSame(5.8, $vector3->get(2)->value());
        $this->assertSame(8.2, $vector3->get(3)->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        Vector::initialize(new Integer(1), new Number(1))->add(
            Vector::initialize(new Integer(2), new Number(1))
        );
    }

    public function testPower()
    {
        $vector1 = new Vector(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(new Number(3));

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertSame(1, $vector2->get(0)->value());
        $this->assertSame(8, $vector2->get(1)->value());
        $this->assertSame(27, $vector2->get(2)->value());
        $this->assertSame(-64, $vector2->get(3)->value());
    }

    public function testSum()
    {
        $vector = new Vector(...numerize(1, 2, 3, -4));

        $this->assertInstanceOf(NumberInterface::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }

    public function testForeach()
    {
        $vector = new Vector(...numerize(1, 2, 3, -4));
        $count = 0;
        $vector->foreach(function() use (&$count) {
            ++$count;
        });

        $this->assertSame(4, $count);
    }

    public function testMap()
    {
        $vector = new Vector(...numerize(1, 2, 3, -4));
        $vector2 = $vector->map(function($number) {
            return $number->multiplyBy($number);
        });

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertNotSame($vector2, $vector);
        $this->assertSame([1, 2, 3, -4], $vector->toArray());
        $this->assertSame([1, 4, 9, 16], $vector2->toArray());
    }

    public function testReduce()
    {
        $vector = new Vector(...numerize(1, 2, 3, -4));

        $this->assertSame(
            2,
            $vector->reduce(
                0,
                function(int $carry, $number): int {
                    return $carry + $number->value();
                }
            )
        );
    }

    public function testEquals()
    {
        $vector = new Vector(...numerize(1, 2, 3));

        $this->assertTrue($vector->equals($vector));
        $this->assertTrue($vector->equals(new Vector(...numerize(1, 2, 3))));
        $this->assertFalse($vector->equals(new Vector(...numerize(1, 2, 4))));
        $this->assertFalse($vector->equals(new Vector(...numerize(3, 2, 1))));
        $this->assertFalse($vector->equals(new Vector(...numerize(1, 2))));
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\ColumnVector,
    Matrix\RowVector,
    Matrix,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class ColumnVectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = new ColumnVector(...numerize(1, 2, 3));

        $this->assertInstanceOf(\Iterator::class, $vector);
        $this->assertSame(3, $vector->dimension()->value());
        $this->assertInstanceOf(Number::class, $vector->get(0));
        $this->assertInstanceOf(Number::class, $vector->get(1));
        $this->assertInstanceOf(Number::class, $vector->get(2));
        $this->assertSame(1, $vector->get(0)->value());
        $this->assertSame(2, $vector->get(1)->value());
        $this->assertSame(3, $vector->get(2)->value());
        $this->assertSame([1, 2, 3], $vector->toArray());
    }

    public function testDot()
    {
        $number = (new ColumnVector(...numerize(-1, 2)))->dot(
            new RowVector(...numerize(4, 1))
        );

        $this->assertInstanceOf(Number::class, $number);
        $this->assertSame(-2, $number->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimension
     */
    public function testThrowForDotProductWithDifferentDimensions()
    {
        (new ColumnVector(...numerize(-1, 2)))->dot(
            new RowVector(...numerize(4, 1, 0))
        );
    }

    public function testMatrix()
    {
        $matrix = (new ColumnVector(...numerize(-1, 2)))->matrix(
            new RowVector(...numerize(4, 1, 2))
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame('2 x 3', (string) $matrix->dimension());
        $this->assertSame(
            [
                [-4, -1, -2],
                [8, 2, 4],
            ],
            $matrix->toArray()
        );
    }

    public function testMultiplyBy()
    {
        $column = new ColumnVector(...numerize(25, 5, 1));
        $column2 = $column->multiplyBy(
            ColumnVector::initialize(new Integer(3), new Number\Number(2.56))
        );

        $this->assertInstanceOf(ColumnVector::class, $column2);
        $this->assertSame([25, 5, 1], $column->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $column2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimension
     */
    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(new Integer(1), new Number\Number(1))->multiplyBy(
            ColumnVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testDivideBy()
    {
        $column = new ColumnVector(...numerize(25, 5, 1));
        $column2 = $column->divideBy(
            ColumnVector::initialize(new Integer(3), new Number\Number(5))
        );

        $this->assertInstanceOf(ColumnVector::class, $column2);
        $this->assertSame([25, 5, 1], $column->toArray());
        $this->assertSame([5, 1, 0.2], $column2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimension
     */
    public function testThrowWhenDividingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(new Integer(1), new Number\Number(1))->divideBy(
            ColumnVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testInitialize()
    {
        $vector = ColumnVector::initialize(new Integer(4), new Number\Number(1.2));

        $this->assertInstanceOf(ColumnVector::class, $vector);
        $this->assertSame([1.2, 1.2, 1.2, 1.2], $vector->toArray());
    }

    public function testSubtract()
    {
        $vector1 = new ColumnVector(...numerize(1, 2, 3, 4));
        $vector2 = new ColumnVector(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(ColumnVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [0.5, -0.5, 0.2, -0.2],
            $vector3->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimension
     */
    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(new Integer(1), new Number\Number(1))->subtract(
            ColumnVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testAdd()
    {
        $vector1 = new ColumnVector(...numerize(1, 2, 3, 4));
        $vector2 = new ColumnVector(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(ColumnVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [1.5, 4.5, 5.8, 8.2],
            $vector3->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimension
     */
    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(new Integer(1), new Number\Number(1))->add(
            ColumnVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testPower()
    {
        $vector1 = new ColumnVector(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(new Number\Number(3));

        $this->assertInstanceOf(ColumnVector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertEquals(
            [1.0, 8.0, 27.0, -64.0],
            $vector2->toArray()
        );
    }

    public function testSum()
    {
        $vector = new ColumnVector(...numerize(1, 2, 3, -4));

        $this->assertInstanceOf(Number::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }

    public function testForeach()
    {
        $vector = new ColumnVector(...numerize(1, 2, 3, -4));
        $count = 0;
        $vector->foreach(function() use (&$count) {
            ++$count;
        });

        $this->assertSame(4, $count);
    }

    public function testMap()
    {
        $vector = new ColumnVector(...numerize(1, 2, 3, -4));
        $vector2 = $vector->map(function($number) {
            return $number->multiplyBy($number);
        });

        $this->assertInstanceOf(ColumnVector::class, $vector2);
        $this->assertNotSame($vector2, $vector);
        $this->assertSame([1, 2, 3, -4], $vector->toArray());
        $this->assertSame([1, 4, 9, 16], $vector2->toArray());
    }

    public function testReduce()
    {
        $vector = new ColumnVector(...numerize(1, 2, 3, -4));

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
        $vector = new ColumnVector(...numerize(1, 2, 3));

        $this->assertTrue($vector->equals($vector));
        $this->assertTrue($vector->equals(new ColumnVector(...numerize(1, 2, 3))));
        $this->assertFalse($vector->equals(new ColumnVector(...numerize(3, 2, 1))));
        $this->assertFalse($vector->equals(new ColumnVector(...numerize(1, 2))));
    }

    /**
     * @dataProvider leads
     */
    public function testLead($numbers, $expected)
    {
        $vector = new ColumnVector(...numerize(...$numbers));

        $this->assertInstanceOf(Number::class, $vector->lead());
        $this->assertSame($expected, $vector->lead()->value());
    }

    public function leads(): array
    {
        return [
            [
                [1, 2, 3],
                1,
            ],
            [
                [0, 2, 3],
                2,
            ],
            [
                [0, 3, 0, 2],
                3,
            ],
            [
                [0, 0, 0, 0],
                0,
            ],
        ];
    }
}

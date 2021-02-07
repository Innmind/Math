<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\RowVector,
    Matrix\ColumnVector,
    Matrix,
    Algebra\Number,
    Algebra\Integer,
    Exception\VectorsMustMeOfTheSameDimension
};
use PHPUnit\Framework\TestCase;

class RowVectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = new RowVector(...numerize(1, 2, 3));

        $this->assertSame([1, 2, 3], $vector->toArray());
        $this->assertSame(3, $vector->dimension()->value());
        $this->assertInstanceOf(Number::class, $vector->get(0));
        $this->assertInstanceOf(Number::class, $vector->get(1));
        $this->assertInstanceOf(Number::class, $vector->get(2));
        $this->assertSame(1, $vector->get(0)->value());
        $this->assertSame(2, $vector->get(1)->value());
        $this->assertSame(3, $vector->get(2)->value());
        $this->assertEquals(numerize(1, 2, 3), $vector->numbers());
    }

    public function testDot()
    {
        $number = (new RowVector(...numerize(-1, 2)))->dot(
            new ColumnVector(...numerize(4, 1))
        );

        $this->assertInstanceOf(Number::class, $number);
        $this->assertSame(-2, $number->value());
    }

    public function testThrowForDotProductWithDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        (new RowVector(...numerize(-1, 2)))->dot(
            new ColumnVector(...numerize(4, 1, 0))
        );
    }

    public function testMatrix()
    {
        $matrix = (new RowVector(...numerize(-1, 2)))->matrix(
            new ColumnVector(...numerize(4, 1, 2))
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame('3 x 2', $matrix->dimension()->toString());
        $this->assertSame(
            [
                [-4, 8],
                [-1, 2],
                [-2, 4],
            ],
            $matrix->toArray()
        );
    }

    public function testMultiplyBy()
    {
        $row = new RowVector(...numerize(25, 5, 1));
        $row2 = $row->multiplyBy(
            RowVector::initialize(new Integer(3), new Number\Number(2.56))
        );

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame([25, 5, 1], $row->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $row2->toArray());
    }

    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(new Integer(1), new Number\Number(1))->multiplyBy(
            RowVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testDivideBy()
    {
        $row = new RowVector(...numerize(25, 5, 1));
        $row2 = $row->divideBy(
            RowVector::initialize(new Integer(3), new Number\Number(5))
        );

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame([25, 5, 1], $row->toArray());
        $this->assertSame([5, 1, 0.2], $row2->toArray());
    }

    public function testThrowWhenDevidingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(new Integer(1), new Number\Number(1))->divideBy(
            RowVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testInitialize()
    {
        $vector = RowVector::initialize(new Integer(4), new Number\Number(1.2));

        $this->assertInstanceOf(RowVector::class, $vector);
        $this->assertSame([1.2, 1.2, 1.2, 1.2], $vector->toArray());
    }

    public function testSubtract()
    {
        $vector1 = new RowVector(...numerize(1, 2, 3, 4));
        $vector2 = new RowVector(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(RowVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [0.5, -0.5, 0.2, -0.2],
            $vector3->toArray()
        );
    }

    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(new Integer(1), new Number\Number(1))->subtract(
            RowVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testAdd()
    {
        $vector1 = new RowVector(...numerize(1, 2, 3, 4));
        $vector2 = new RowVector(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(RowVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [1.5, 4.5, 5.8, 8.2],
            $vector3->toArray()
        );
    }

    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(new Integer(1), new Number\Number(1))->add(
            RowVector::initialize(new Integer(2), new Number\Number(1))
        );
    }

    public function testPower()
    {
        $vector1 = new RowVector(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(new Number\Number(3));

        $this->assertInstanceOf(RowVector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertEquals(
            [1, 8, 27, -64],
            $vector2->toArray()
        );
    }

    public function testSum()
    {
        $vector = new RowVector(...numerize(1, 2, 3, -4));

        $this->assertInstanceOf(Number::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }

    public function testForeach()
    {
        $vector = new RowVector(...numerize(1, 2, 3, -4));
        $count = 0;
        $vector->foreach(static function() use (&$count) {
            ++$count;
        });

        $this->assertSame(4, $count);
    }

    public function testMap()
    {
        $vector = new RowVector(...numerize(1, 2, 3, -4));
        $vector2 = $vector->map(static function($number) {
            return $number->multiplyBy($number);
        });

        $this->assertInstanceOf(RowVector::class, $vector2);
        $this->assertNotSame($vector2, $vector);
        $this->assertSame([1, 2, 3, -4], $vector->toArray());
        $this->assertSame([1, 4, 9, 16], $vector2->toArray());
    }

    public function testReduce()
    {
        $vector = new RowVector(...numerize(1, 2, 3, -4));

        $this->assertSame(
            2,
            $vector->reduce(
                0,
                static function(int $carry, $number): int {
                    return $carry + $number->value();
                }
            )
        );
    }

    public function testEquals()
    {
        $vector = new RowVector(...numerize(1, 2, 3));

        $this->assertTrue($vector->equals($vector));
        $this->assertTrue($vector->equals(new RowVector(...numerize(1, 2, 3))));
        $this->assertFalse($vector->equals(new RowVector(...numerize(3, 2, 1))));
        $this->assertFalse($vector->equals(new RowVector(...numerize(1, 2))));
    }

    /**
     * @dataProvider leads
     */
    public function testLead($numbers, $expected)
    {
        $vector = new RowVector(...numerize(...$numbers));

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

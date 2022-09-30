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
    Algebra\Real,
    Exception\VectorsMustMeOfTheSameDimension
};
use PHPUnit\Framework\TestCase;

class RowVectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = RowVector::of(...numerize(1, 2, 3));

        $this->assertSame(
            [1, 2, 3],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
        $this->assertSame(3, $vector->dimension()->value());
        $this->assertInstanceOf(Number::class, $vector->get(0));
        $this->assertInstanceOf(Number::class, $vector->get(1));
        $this->assertInstanceOf(Number::class, $vector->get(2));
        $this->assertSame(1, $vector->get(0)->value());
        $this->assertSame(2, $vector->get(1)->value());
        $this->assertSame(3, $vector->get(2)->value());
    }

    public function testDot()
    {
        $number = RowVector::of(...numerize(-1, 2))->dot(
            ColumnVector::of(...numerize(4, 1)),
        );

        $this->assertInstanceOf(Number::class, $number);
        $this->assertSame(-2, $number->value());
    }

    public function testThrowForDotProductWithDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::of(...numerize(-1, 2))->dot(
            ColumnVector::of(...numerize(4, 1, 0)),
        );
    }

    public function testMatrix()
    {
        $matrix = RowVector::of(...numerize(-1, 2))->matrix(
            ColumnVector::of(...numerize(4, 1, 2)),
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame('3 x 2', $matrix->dimension()->toString());
        $this->assertTrue($matrix->equals(Matrix::of(
            [
                [-4, 8],
                [-1, 2],
                [-2, 4],
            ],
        )));
    }

    public function testMultiplyBy()
    {
        $row = RowVector::of(...numerize(25, 5, 1));
        $row2 = $row->multiplyBy(
            RowVector::initialize(Integer::of(3), Real::of(2.56)),
        );

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame(
            [25, 5, 1],
            $row
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
        $this->assertSame(
            [64.0, 12.8, 2.56],
            $row2
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(Integer::of(1), Real::of(1))->multiplyBy(
            RowVector::initialize(Integer::of(2), Real::of(1)),
        );
    }

    public function testDivideBy()
    {
        $row = RowVector::of(...numerize(25, 5, 1));
        $row2 = $row->divideBy(
            RowVector::initialize(Integer::of(3), Real::of(5)),
        );

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame(
            [25, 5, 1],
            $row
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
        $this->assertSame(
            [5, 1, 0.2],
            $row2
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testThrowWhenDevidingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(Integer::of(1), Real::of(1))->divideBy(
            RowVector::initialize(Integer::of(2), Real::of(1)),
        );
    }

    public function testInitialize()
    {
        $vector = RowVector::initialize(Integer::of(4), Real::of(1.2));

        $this->assertInstanceOf(RowVector::class, $vector);
        $this->assertSame(
            [1.2, 1.2, 1.2, 1.2],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testSubtract()
    {
        $vector1 = RowVector::of(...numerize(1, 2, 3, 4));
        $vector2 = RowVector::of(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(RowVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [0.5, -0.5, 0.20000000000000018, -0.20000000000000018],
            $vector3
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(Integer::of(1), Real::of(1))->subtract(
            RowVector::initialize(Integer::of(2), Real::of(1)),
        );
    }

    public function testAdd()
    {
        $vector1 = RowVector::of(...numerize(1, 2, 3, 4));
        $vector2 = RowVector::of(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(RowVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [1.5, 4.5, 5.8, 8.2],
            $vector3
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        RowVector::initialize(Integer::of(1), Real::of(1))->add(
            RowVector::initialize(Integer::of(2), Real::of(1)),
        );
    }

    public function testPower()
    {
        $vector1 = RowVector::of(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(Real::of(3));

        $this->assertInstanceOf(RowVector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertEquals(
            [1, 8, 27, -64],
            $vector2
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testSum()
    {
        $vector = RowVector::of(...numerize(1, 2, 3, -4));

        $this->assertInstanceOf(Number::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }

    public function testForeach()
    {
        $vector = RowVector::of(...numerize(1, 2, 3, -4));
        $count = 0;
        $vector->foreach(static function() use (&$count) {
            ++$count;
        });

        $this->assertSame(4, $count);
    }

    public function testMap()
    {
        $vector = RowVector::of(...numerize(1, 2, 3, -4));
        $vector2 = $vector->map(static function($number) {
            return $number->multiplyBy($number);
        });

        $this->assertInstanceOf(RowVector::class, $vector2);
        $this->assertNotSame($vector2, $vector);
        $this->assertSame(
            [1, 2, 3, -4],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
        $this->assertSame(
            [1, 4, 9, 16],
            $vector2
                ->toSequence()
                ->map(static fn($number) => $number->collapse()->value())
                ->toList(),
        );
    }

    public function testReduce()
    {
        $vector = RowVector::of(...numerize(1, 2, 3, -4));

        $this->assertSame(
            2,
            $vector->reduce(
                0,
                static function(int $carry, $number): int {
                    return $carry + $number->value();
                },
            ),
        );
    }

    public function testEquals()
    {
        $vector = RowVector::of(...numerize(1, 2, 3));

        $this->assertTrue($vector->equals($vector));
        $this->assertTrue($vector->equals(RowVector::of(...numerize(1, 2, 3))));
        $this->assertFalse($vector->equals(RowVector::of(...numerize(3, 2, 1))));
        $this->assertFalse($vector->equals(RowVector::of(...numerize(1, 2))));
    }

    /**
     * @dataProvider leads
     */
    public function testLead($numbers, $expected)
    {
        $vector = RowVector::of(...numerize(...$numbers));

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

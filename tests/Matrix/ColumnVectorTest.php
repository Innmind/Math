<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\ColumnVector,
    Matrix\RowVector,
    Matrix,
    Algebra\Number,
    Exception\VectorsMustMeOfTheSameDimension
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ColumnVectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = ColumnVector::of(...numerize(1, 2, 3));

        $this->assertSame(3, $vector->dimension());
        $this->assertInstanceOf(Number::class, $vector->get(0));
        $this->assertInstanceOf(Number::class, $vector->get(1));
        $this->assertInstanceOf(Number::class, $vector->get(2));
        $this->assertSame(1, $vector->get(0)->value());
        $this->assertSame(2, $vector->get(1)->value());
        $this->assertSame(3, $vector->get(2)->value());
        $this->assertSame(
            [1, 2, 3],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testDot()
    {
        $number = ColumnVector::of(...numerize(-1, 2))->dot(
            RowVector::of(...numerize(4, 1)),
        );

        $this->assertInstanceOf(Number::class, $number);
        $this->assertSame(-2, $number->value());
    }

    public function testThrowForDotProductWithDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        ColumnVector::of(...numerize(-1, 2))->dot(
            RowVector::of(...numerize(4, 1, 0)),
        );
    }

    public function testMatrix()
    {
        $matrix = ColumnVector::of(...numerize(-1, 2))->matrix(
            RowVector::of(...numerize(4, 1, 2)),
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame('2 x 3', $matrix->dimension()->toString());
        $this->assertTrue($matrix->equals(Matrix::of(
            [
                [-4, -1, -2],
                [8, 2, 4],
            ],
        )));
    }

    public function testMultiplyBy()
    {
        $column = ColumnVector::of(...numerize(25, 5, 1));
        $column2 = $column->multiplyBy(
            ColumnVector::initialize(3, Number::of(2.56)),
        );

        $this->assertInstanceOf(ColumnVector::class, $column2);
        $this->assertSame(
            [25, 5, 1],
            $column
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
        $this->assertSame(
            [64.0, 12.8, 2.56],
            $column2
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        ColumnVector::initialize(1, Number::of(1))->multiplyBy(
            ColumnVector::initialize(2, Number::of(1)),
        );
    }

    public function testDivideBy()
    {
        $column = ColumnVector::of(...numerize(25, 5, 1));
        $column2 = $column->divideBy(
            ColumnVector::initialize(3, Number::of(5)),
        );

        $this->assertInstanceOf(ColumnVector::class, $column2);
        $this->assertSame(
            [25, 5, 1],
            $column
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
        $this->assertSame(
            [5, 1, 0.2],
            $column2
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testThrowWhenDividingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        ColumnVector::initialize(1, Number::of(1))->divideBy(
            ColumnVector::initialize(2, Number::of(1)),
        );
    }

    public function testInitialize()
    {
        $vector = ColumnVector::initialize(4, Number::of(1.2));

        $this->assertInstanceOf(ColumnVector::class, $vector);
        $this->assertSame(
            [1.2, 1.2, 1.2, 1.2],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testSubtract()
    {
        $vector1 = ColumnVector::of(...numerize(1, 2, 3, 4));
        $vector2 = ColumnVector::of(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(ColumnVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [0.5, -0.5, 0.20000000000000018, -0.20000000000000018],
            $vector3
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        ColumnVector::initialize(1, Number::of(1))->subtract(
            ColumnVector::initialize(2, Number::of(1)),
        );
    }

    public function testAdd()
    {
        $vector1 = ColumnVector::of(...numerize(1, 2, 3, 4));
        $vector2 = ColumnVector::of(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(ColumnVector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertEquals(
            [1.5, 4.5, 5.8, 8.2],
            $vector3
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        ColumnVector::initialize(1, Number::of(1))->add(
            ColumnVector::initialize(2, Number::of(1)),
        );
    }

    public function testPower()
    {
        $vector1 = ColumnVector::of(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(Number::of(3));

        $this->assertInstanceOf(ColumnVector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertEquals(
            [1.0, 8.0, 27.0, -64.0],
            $vector2
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testSum()
    {
        $vector = ColumnVector::of(...numerize(1, 2, 3, -4));

        $this->assertInstanceOf(Number::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }

    public function testForeach()
    {
        $vector = ColumnVector::of(...numerize(1, 2, 3, -4));
        $count = 0;
        $vector->foreach(static function() use (&$count) {
            ++$count;
        });

        $this->assertSame(4, $count);
    }

    public function testMap()
    {
        $vector = ColumnVector::of(...numerize(1, 2, 3, -4));
        $vector2 = $vector->map(static function($number) {
            return $number->multiplyBy($number);
        });

        $this->assertInstanceOf(ColumnVector::class, $vector2);
        $this->assertNotSame($vector2, $vector);
        $this->assertEquals(
            [1, 2, 3, -4],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
        $this->assertEquals(
            [1, 4, 9, 16],
            $vector2
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testReduce()
    {
        $vector = ColumnVector::of(...numerize(1, 2, 3, -4));

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
        $vector = ColumnVector::of(...numerize(1, 2, 3));

        $this->assertTrue($vector->equals($vector));
        $this->assertTrue($vector->equals(ColumnVector::of(...numerize(1, 2, 3))));
        $this->assertFalse($vector->equals(ColumnVector::of(...numerize(3, 2, 1))));
        $this->assertFalse($vector->equals(ColumnVector::of(...numerize(1, 2))));
    }

    #[DataProvider('leads')]
    public function testLead($numbers, $expected)
    {
        $vector = ColumnVector::of(...numerize(...$numbers));

        $this->assertInstanceOf(Number::class, $vector->lead());
        $this->assertSame($expected, $vector->lead()->value());
    }

    public static function leads(): array
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

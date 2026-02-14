<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\Vector,
    Algebra\Number,
    Exception\VectorsMustMeOfTheSameDimension
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class VectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = Vector::of(...numerize(1, 2, 3));

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
        $number = Vector::of(...numerize(-1, 2))->dot(
            Vector::of(...numerize(4, 1)),
        );

        $this->assertInstanceOf(Number::class, $number);
        $this->assertSame(-2, $number->value());
    }

    public function testThrowForDotProductWithDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        Vector::of(...numerize(-1, 2))->dot(
            Vector::of(...numerize(4, 1, 0)),
        );
    }

    public function testMultiplyBy()
    {
        $vector = Vector::of(...numerize(25, 5, 1));
        $vector2 = $vector->multiplyBy(
            Vector::initialize(3, Number::of(2.56)),
        );

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertSame(25, $vector->get(0)->value());
        $this->assertSame(5, $vector->get(1)->value());
        $this->assertSame(1, $vector->get(2)->value());
        $this->assertSame(64.0, $vector2->get(0)->value());
        $this->assertSame(12.8, $vector2->get(1)->value());
        $this->assertSame(2.56, $vector2->get(2)->value());
    }

    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        Vector::initialize(1, Number::of(1))->multiplyBy(
            Vector::initialize(2, Number::of(1)),
        );
    }

    public function testDivideBy()
    {
        $vector = Vector::of(...numerize(25, 5, 1));
        $vector2 = $vector->divideBy(
            Vector::initialize(3, Number::of(5)),
        );

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertSame(25, $vector->get(0)->value());
        $this->assertSame(5, $vector->get(1)->value());
        $this->assertSame(1, $vector->get(2)->value());
        $this->assertSame(5, $vector2->get(0)->value());
        $this->assertSame(1, $vector2->get(1)->value());
        $this->assertSame(0.2, $vector2->get(2)->value());
    }

    public function testThrowWhenDevidingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        Vector::initialize(1, Number::of(1))->divideBy(
            Vector::initialize(2, Number::of(1)),
        );
    }

    public function testInitialize()
    {
        $vector = Vector::initialize(4, Number::of(1.2));

        $this->assertInstanceOf(Vector::class, $vector);
        $this->assertSame(1.2, $vector->get(0)->value());
        $this->assertSame(1.2, $vector->get(1)->value());
        $this->assertSame(1.2, $vector->get(2)->value());
        $this->assertSame(1.2, $vector->get(3)->value());
    }

    public function testSubtract()
    {
        $vector1 = Vector::of(...numerize(1, 2, 3, 4));
        $vector2 = Vector::of(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(Vector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertSame(0.5, $vector3->get(0)->value());
        $this->assertSame(-0.5, $vector3->get(1)->value());
        $this->assertEqualsWithDelta(
            0.2,
            $vector3->get(2)->value(),
            0.01,
        );
        $this->assertEqualsWithDelta(
            -0.2,
            $vector3->get(3)->value(),
            0.01,
        );
    }

    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        Vector::initialize(1, Number::of(1))->subtract(
            Vector::initialize(2, Number::of(1)),
        );
    }

    public function testAdd()
    {
        $vector1 = Vector::of(...numerize(1, 2, 3, 4));
        $vector2 = Vector::of(...numerize(0.5, 2.5, 2.8, 4.2));

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(Vector::class, $vector3);
        $this->assertNotSame($vector3, $vector1);
        $this->assertNotSame($vector3, $vector2);
        $this->assertSame(1.5, $vector3->get(0)->value());
        $this->assertSame(4.5, $vector3->get(1)->value());
        $this->assertSame(5.8, $vector3->get(2)->value());
        $this->assertSame(8.2, $vector3->get(3)->value());
    }

    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        Vector::initialize(1, Number::of(1))->add(
            Vector::initialize(2, Number::of(1)),
        );
    }

    public function testPower()
    {
        $vector1 = Vector::of(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(Number::of(3));

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertSame(1, $vector2->get(0)->value());
        $this->assertSame(8, $vector2->get(1)->value());
        $this->assertSame(27, $vector2->get(2)->value());
        $this->assertSame(-64, $vector2->get(3)->value());
    }

    public function testSum()
    {
        $vector = Vector::of(...numerize(1, 2, 3, -4));

        $this->assertInstanceOf(Number::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }

    public function testForeach()
    {
        $vector = Vector::of(...numerize(1, 2, 3, -4));
        $count = 0;
        $vector->foreach(static function() use (&$count) {
            ++$count;
        });

        $this->assertSame(4, $count);
    }

    public function testMap()
    {
        $vector = Vector::of(...numerize(1, 2, 3, -4));
        $vector2 = $vector->map(static function($number) {
            return $number->multiplyBy($number);
        });

        $this->assertInstanceOf(Vector::class, $vector2);
        $this->assertNotSame($vector2, $vector);
        $this->assertSame(
            [1, 2, 3, -4],
            $vector
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
        $this->assertSame(
            [1, 4, 9, 16],
            $vector2
                ->toSequence()
                ->map(static fn($number) => $number->optimize()->value())
                ->toList(),
        );
    }

    public function testReduce()
    {
        $vector = Vector::of(...numerize(1, 2, 3, -4));

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
        $vector = Vector::of(...numerize(1, 2, 3));

        $this->assertTrue($vector->equals($vector));
        $this->assertTrue($vector->equals(Vector::of(...numerize(1, 2, 3))));
        $this->assertFalse($vector->equals(Vector::of(...numerize(1, 2, 4))));
        $this->assertFalse($vector->equals(Vector::of(...numerize(3, 2, 1))));
        $this->assertFalse($vector->equals(Vector::of(...numerize(1, 2))));
    }

    #[DataProvider('leads')]
    public function testLead($numbers, $expected)
    {
        $vector = Vector::of(...numerize(...$numbers));

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

    private function assertEqualsWithDelta(
        int|float $expected,
        int|float $value,
        int|float $delta,
    ): void {
        $this->assertGreaterThanOrEqual($expected-$delta, $value);
        $this->assertLessThanOrEqual($expected+$delta, $value);
    }
}

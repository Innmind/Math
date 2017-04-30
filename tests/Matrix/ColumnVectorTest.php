<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\ColumnVector,
    Matrix\RowVector,
    Matrix,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ColumnVectorTest extends TestCase
{
    public function testInterface()
    {
        $vector = new ColumnVector(...numerize(1, 2, 3));

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
        $number = (new ColumnVector(...numerize(-1, 2)))->dot(
            new RowVector(...numerize(4, 1))
        );

        $this->assertInstanceOf(NumberInterface::class, $number);
        $this->assertSame(-2, $number->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowForDotProductWithDifferentDimensions()
    {
        (new ColumnVector(...numerize(-1, 2)))->dot(
            new RowVector(...numerize(4, 1, 0))
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorCannotBeEmptyException
     */
    public function testThrowWhenEmptyVector()
    {
        new ColumnVector;
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

    public function testMultiply()
    {
        $column = new ColumnVector(...numerize(25, 5, 1));
        $column2 = $column->multiply(ColumnVector::initialize(3, new Number(2.56)));

        $this->assertInstanceOf(ColumnVector::class, $column2);
        $this->assertSame([25, 5, 1], $column->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $column2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(1, new Number(1))->multiply(
            ColumnVector::initialize(2, new Number(1))
        );
    }

    public function testDivide()
    {
        $column = new ColumnVector(...numerize(25, 5, 1));
        $column2 = $column->divide(ColumnVector::initialize(3, new Number(5)));

        $this->assertInstanceOf(ColumnVector::class, $column2);
        $this->assertSame([25, 5, 1], $column->toArray());
        $this->assertSame([5, 1, 0.2], $column2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenDividingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(1, new Number(1))->divide(
            ColumnVector::initialize(2, new Number(1))
        );
    }

    public function testInitialize()
    {
        $vector = ColumnVector::initialize(4, new Number(1.2));

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
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenSubtractingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(1, new Number(1))->subtract(
            ColumnVector::initialize(2, new Number(1))
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
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenAddingVectorsOfDifferentDimensions()
    {
        ColumnVector::initialize(1, new Number(1))->add(
            ColumnVector::initialize(2, new Number(1))
        );
    }

    public function testPower()
    {
        $vector1 = new ColumnVector(...numerize(1, 2, 3, -4));

        $vector2 = $vector1->power(new Number(3));

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

        $this->assertInstanceOf(NumberInterface::class, $vector->sum());
        $this->assertSame(2, $vector->sum()->value());
    }
}

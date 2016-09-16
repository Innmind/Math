<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Vector;

use Innmind\Math\{
    Vector\RowVector,
    Vector\ColumnVector,
    Matrix
};

class RowVectorTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $vector = new RowVector(1, 2, 3);

        $this->assertSame([1.0, 2.0, 3.0], $vector->toArray());
        $this->assertInstanceOf(\Iterator::class, $vector);
        $this->assertSame(3, $vector->dimension());
        $this->assertSame(1.0, $vector->get(0));
        $this->assertSame(2.0, $vector->get(1));
        $this->assertSame(3.0, $vector->get(2));
    }

    public function testDot()
    {
        $number = (new RowVector(-1, 2))->dot(new ColumnVector(4, 1));

        $this->assertSame(-2.0, $number);
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowForDotProductWithDifferentDimensions()
    {
        (new RowVector(-1, 2))->dot(new ColumnVector(4, 1, 0));
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorCannotBeEmptyException
     */
    public function testThrowWhenEmptyVector()
    {
        new RowVector;
    }

    public function testMatrix()
    {
        $matrix = (new RowVector(-1, 2))->matrix(new ColumnVector(4, 1, 2));

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame('3 x 2', (string) $matrix->dimension());
        $this->assertSame(
            [
                [-4.0, 8.0],
                [-1.0, 2.0],
                [-2.0, 4.0],
            ],
            $matrix->toArray()
        );
    }

    public function testMultiply()
    {
        $row = new RowVector(25, 5, 1);
        $row2 = $row->multiply(RowVector::initialize(3, 2.56));

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame([25.0, 5.0, 1.0], $row->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $row2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenMultiplyingVectorsOfDifferentDimensions()
    {
        RowVector::initialize(1, 1)->multiply(RowVector::initialize(2, 1));
    }

    public function testDivide()
    {
        $row = new RowVector(25, 5, 1);
        $row2 = $row->divide(RowVector::initialize(3, 5));

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame([25.0, 5.0, 1.0], $row->toArray());
        $this->assertSame([5.0, 1.0, 0.2], $row2->toArray());
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenDevidingVectorsOfDifferentDimensions()
    {
        RowVector::initialize(1, 1)->divide(RowVector::initialize(2, 1));
    }

    public function testInitialize()
    {
        $vector = RowVector::initialize(4, 1.2);

        $this->assertInstanceOf(RowVector::class, $vector);
        $this->assertSame([1.2, 1.2, 1.2, 1.2], $vector->toArray());
    }

    public function testSubtract()
    {
        $vector1 = new RowVector(1, 2, 3, 4);
        $vector2 = new RowVector(0.5, 2.5, 2.8, 4.2);

        $vector3 = $vector1->subtract($vector2);

        $this->assertInstanceOf(RowVector::class, $vector3);
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
        RowVector::initialize(1, 1)->subtract(RowVector::initialize(2, 1));
    }

    public function testAdd()
    {
        $vector1 = new RowVector(1, 2, 3, 4);
        $vector2 = new RowVector(0.5, 2.5, 2.8, 4.2);

        $vector3 = $vector1->add($vector2);

        $this->assertInstanceOf(RowVector::class, $vector3);
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
        RowVector::initialize(1, 1)->add(RowVector::initialize(2, 1));
    }

    public function testPower()
    {
        $vector1 = new RowVector(1, 2, 3, -4);

        $vector2 = $vector1->power(3);

        $this->assertInstanceOf(RowVector::class, $vector2);
        $this->assertNotSame($vector2, $vector1);
        $this->assertEquals(
            [1.0, 8.0, 27.0, -64.0],
            $vector2->toArray()
        );
    }

    public function testSum()
    {
        $vector = new RowVector(1, 2, 3, -4);

        $this->assertSame(2.0, $vector->sum());
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Vector;

use Innmind\Math\{
    Vector\ColumnVector,
    Vector\RowVector,
    Matrix
};

class ColumnVectorTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $vector = new ColumnVector(1, 2, 3);

        $this->assertSame([1.0, 2.0, 3.0], $vector->toArray());
        $this->assertInstanceOf(\Iterator::class, $vector);
        $this->assertSame(3, $vector->dimension());
        $this->assertSame(1.0, $vector->get(0));
        $this->assertSame(2.0, $vector->get(1));
        $this->assertSame(3.0, $vector->get(2));
    }

    public function testDot()
    {
        $number = (new ColumnVector(-1, 2))->dot(new RowVector(4, 1));

        $this->assertSame(-2.0, $number);
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowForDotProductWithDifferentDimensions()
    {
        (new ColumnVector(-1, 2))->dot(new RowVector(4, 1, 0));
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
        $matrix = (new ColumnVector(-1, 2))->matrix(new RowVector(4, 1, 2));

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame('2 x 3', (string) $matrix->dimension());
        $this->assertSame(
            [
                [-4.0, -1.0, -2.0],
                [8.0, 2.0, 4.0],
            ],
            $matrix->toArray()
        );
    }

    public function testMultiply()
    {
        $row = new ColumnVector(25, 5, 1);
        $row2 = $row->multiply(2.56);

        $this->assertInstanceOf(ColumnVector::class, $row2);
        $this->assertSame([25.0, 5.0, 1.0], $row->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $row2->toArray());
    }

    public function testInitialize()
    {
        $vector = ColumnVector::initialize(4, 1.2);

        $this->assertInstanceOf(ColumnVector::class, $vector);
        $this->assertSame([1.2, 1.2, 1.2, 1.2], $vector->toArray());
    }

    public function testSubtract()
    {
        $vector1 = new ColumnVector(1, 2, 3, 4);
        $vector2 = new ColumnVector(0.5, 2.5, 2.8, 4.2);

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
        ColumnVector::initialize(1, 1)->subtract(ColumnVector::initialize(2, 1));
    }

    public function testAdd()
    {
        $vector1 = new ColumnVector(1, 2, 3, 4);
        $vector2 = new ColumnVector(0.5, 2.5, 2.8, 4.2);

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
        ColumnVector::initialize(1, 1)->add(ColumnVector::initialize(2, 1));
    }
}

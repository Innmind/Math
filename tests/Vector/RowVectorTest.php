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
        $row2 = $row->multiply(2.56);

        $this->assertInstanceOf(RowVector::class, $row2);
        $this->assertSame([25.0, 5.0, 1.0], $row->toArray());
        $this->assertSame([64.0, 12.8, 2.56], $row2->toArray());
    }
}

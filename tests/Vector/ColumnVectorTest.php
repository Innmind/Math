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
}

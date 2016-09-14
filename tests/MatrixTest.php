<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math;

use Innmind\Math\{
    Matrix,
    Matrix\Dimension,
    Vector\RowVector,
    Vector\ColumnVector
};

class MatrixTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $rows = [
            new RowVector(1, 2, 3),
            new RowVector(2, 3, 4),
        ];
        $matrix = new Matrix(...$rows);

        $this->assertInstanceOf(\Iterator::class, $matrix);
        $this->assertInstanceOf(Dimension::class, $matrix->dimension());
        $this->assertSame('2 x 3', (string) $matrix->dimension());
        $this->assertInstanceOf(RowVector::class, $matrix->row(0));
        $this->assertInstanceOf(RowVector::class, $matrix->row(1));
        $this->assertSame($rows[0], $matrix->row(0));
        $this->assertSame($rows[1], $matrix->row(1));
        $this->assertSame(
            [
                [1.0, 2.0, 3.0],
                [2.0, 3.0, 4.0],
            ],
            $matrix->toArray()
        );
        $this->assertInstanceOf(ColumnVector::class, $matrix->column(0));
        $this->assertInstanceOf(ColumnVector::class, $matrix->column(1));
        $this->assertInstanceOf(ColumnVector::class, $matrix->column(2));
        $this->assertSame(
            [1.0, 2.0],
            $matrix->column(0)->toArray()
        );
        $this->assertSame(
            [2.0, 3.0],
            $matrix->column(1)->toArray()
        );
        $this->assertSame(
            [3.0, 4.0],
            $matrix->column(2)->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\MatrixCannotBeEmptyException
     */
    public function testThrowWhenBuildingEmptyMatrix()
    {
        new Matrix;
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenBuildingMatrixWithIncoherentRows()
    {
        new Matrix(
            new RowVector(1, 2),
            new RowVector(1, 2, 3)
        );
    }

    public function testFromArray()
    {
        $matrix = Matrix::fromArray($values = [
            [1.0, 2.0, 3.0],
            [2.0, 3.0, 4.0],
        ]);

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame($values, $matrix->toArray());
    }

    public function testTranspose()
    {
        $matrix = Matrix::fromArray([
            [1, 2, 3],
            [3, 4, 5],
            [2, 3, 4],
        ])->transpose();

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame(
            [
                [1.0, 3.0, 2.0],
                [2.0, 4.0, 3.0],
                [3.0, 5.0, 4.0],
            ],
            $matrix->toArray()
        );
    }

    public function testMultiply()
    {
        $matrix = Matrix::fromArray([
            [1, 2, 3],
            [4, 5, 6],
        ])->multiply(
            Matrix::fromArray([
                [7, 8],
                [9, 10],
                [11, 12],
            ])
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame(
            [
                [58.0, 64.0],
                [139.0, 154.0]
            ],
            $matrix->toArray()
        );
    }

    public function testInitialize()
    {
        $matrix = Matrix::initialize(
            new Dimension(3, 2),
            4.2
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame(
            [
                [4.2, 4.2],
                [4.2, 4.2],
                [4.2, 4.2],
                ],
                $matrix->toArray()
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix,
    Matrix\Dimension,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    public function testInterface()
    {
        $rows = [
            new RowVector(...numerize(1, 2, 3)),
            new RowVector(...numerize(2, 3, 4)),
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
                [1, 2, 3],
                [2, 3, 4],
            ],
            $matrix->toArray()
        );
        $this->assertInstanceOf(ColumnVector::class, $matrix->column(0));
        $this->assertInstanceOf(ColumnVector::class, $matrix->column(1));
        $this->assertInstanceOf(ColumnVector::class, $matrix->column(2));
        $this->assertSame(
            [1, 2],
            $matrix->column(0)->toArray()
        );
        $this->assertSame(
            [2, 3],
            $matrix->column(1)->toArray()
        );
        $this->assertSame(
            [3, 4],
            $matrix->column(2)->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustMeOfTheSameDimensionException
     */
    public function testThrowWhenBuildingMatrixWithIncoherentRows()
    {
        new Matrix(
            new RowVector(...numerize(1, 2)),
            new RowVector(...numerize(1, 2, 3))
        );
    }

    public function testFromArray()
    {
        $matrix = Matrix::fromArray($values = [
            [1, 2, 3],
            [2, 3, 4],
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
                [1, 3, 2],
                [2, 4, 3],
                [3, 5, 4],
            ],
            $matrix->toArray()
        );
    }

    public function testDot()
    {
        $matrix = Matrix::fromArray([
            [1, 2, 3],
            [4, 5, 6],
        ])->dot(
            Matrix::fromArray([
                [7, 8],
                [9, 10],
                [11, 12],
            ])
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame(
            [
                [58, 64],
                [139, 154]
            ],
            $matrix->toArray()
        );
    }

    public function testInitialize()
    {
        $matrix = Matrix::initialize(
            new Dimension(new Integer(3), new Integer(2)),
            new Number(4.2)
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

    public function testIsSquare()
    {
        $this->assertTrue(
            Matrix::fromArray([
                [1, 2],
                [3, 4],
            ])->isSquare()
        );
        $this->assertFalse(
            Matrix::fromArray([
                [1, 2],
            ])->isSquare()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\MatrixMustBeSquareException
     */
    public function testThrowWhenAskingForNonSquareDiagonal()
    {
        Matrix::fromArray([[1, 2]])->diagonal();
    }

    public function testDiagonal()
    {
        $matrix = Matrix::fromArray($initial = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);
        $diagonal = $matrix->diagonal();

        $this->assertInstanceOf(Matrix::class, $diagonal);
        $this->assertNotSame($matrix, $diagonal);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame(
            [
                [1, 0, 0],
                [0, 5, 0],
                [0, 0, 9],
            ],
            $diagonal->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\MatrixMustBeSquareException
     */
    public function testThrowWhenAskingForNonSquareIdentity()
    {
        Matrix::fromArray([[1, 2]])->identity();
    }

    public function testIdentity()
    {
        $matrix = Matrix::fromArray($initial = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);
        $identity = $matrix->identity();

        $this->assertInstanceOf(Matrix::class, $identity);
        $this->assertNotSame($matrix, $identity);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame(
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ],
            $identity->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\MatricesMustBeOfTheSameDimensionException
     */
    public function testThrowWhenAddindMatricesOfDifferentDimensions()
    {
        Matrix::fromArray([[1]])->add(
            Matrix::fromArray([[1, 2]])
        );
    }

    public function testAdd()
    {
        $a = Matrix::fromArray($aValues = [
            [1, 0, -1],
            [2, 1, 4],
        ]);
        $b = Matrix::fromArray($bValues = [
            [0, -1, -2],
            [-3, 1, 5],
        ]);
        $c = $a->add($b);

        $this->assertInstanceOf(Matrix::class, $c);
        $this->assertNotSame($c, $a);
        $this->assertNotSame($c, $b);
        $this->assertSame($aValues, $a->toArray());
        $this->assertSame($bValues, $b->toArray());
        $this->assertSame(
            [
                [1, -1, -3],
                [-1, 2, 9],
            ],
            $c->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\MatricesMustBeOfTheSameDimensionException
     */
    public function testThrowWhenSubtractingMatricesOfDifferentDimensions()
    {
        Matrix::fromArray([[1]])->subtract(
            Matrix::fromArray([[1, 2]])
        );
    }

    public function testSubtract()
    {
        $a = Matrix::fromArray($aValues = [
            [1, 0, -1],
            [2, 1, 4],
        ]);
        $b = Matrix::fromArray($bValues = [
            [0, -1, -2],
            [-3, 1, 5],
        ]);
        $c = $a->subtract($b);

        $this->assertInstanceOf(Matrix::class, $c);
        $this->assertNotSame($c, $a);
        $this->assertNotSame($c, $b);
        $this->assertSame($aValues, $a->toArray());
        $this->assertSame($bValues, $b->toArray());
        $this->assertSame(
            [
                [1, 1, 1],
                [5, 0, -1],
            ],
            $c->toArray()
        );
    }
}

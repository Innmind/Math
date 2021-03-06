<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix,
    Matrix\Dimension,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Algebra\Number\Number,
    Algebra\Integer,
    Exception\VectorsMustMeOfTheSameDimension,
    Exception\MatricesMustBeOfTheSameDimension,
    Exception\MatrixMustBeSquare,
    Exception\MatrixNotInvertible
};
use Innmind\Immutable\Sequence;
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

        $this->assertInstanceOf(Dimension::class, $matrix->dimension());
        $this->assertSame('2 x 3', $matrix->dimension()->toString());
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

    public function testRows()
    {
        $matrix = Matrix::of([
            [1, 2, 3],
            [1, 2, 3],
        ]);

        $this->assertInstanceOf(Sequence::class, $matrix->rows());
        $this->assertSame(RowVector::class, (string) $matrix->rows()->type());
        $this->assertCount(2, $matrix->rows());
    }

    public function testColumns()
    {
        $matrix = Matrix::of([
            [1, 2, 3],
            [1, 2, 3],
        ]);

        $this->assertInstanceOf(Sequence::class, $matrix->columns());
        $this->assertSame(ColumnVector::class, (string) $matrix->columns()->type());
        $this->assertCount(3, $matrix->columns());
    }

    public function testThrowWhenBuildingMatrixWithIncoherentRows()
    {
        $this->expectException(VectorsMustMeOfTheSameDimension::class);

        new Matrix(
            new RowVector(...numerize(1, 2)),
            new RowVector(...numerize(1, 2, 3))
        );
    }

    public function testFromArray()
    {
        $matrix = Matrix::of($values = [
            [1, 2, 3],
            [2, 3, 4],
        ]);

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame($values, $matrix->toArray());
    }

    public function testFromColumns()
    {
        $matrix = Matrix::fromColumns(
            new ColumnVector(...numerize(1, 2, 3)),
            new ColumnVector(...numerize(4, 5, 6))
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame(
            [
                [1, 4],
                [2, 5],
                [3, 6],
            ],
            $matrix->toArray()
        );
    }

    public function testTranspose()
    {
        $matrix = Matrix::of([
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
        $matrix = Matrix::of([
            [1, 2, 3],
            [4, 5, 6],
        ])->dot(
            Matrix::of([
                [7, 8],
                [9, 10],
                [11, 12],
            ])
        );

        $this->assertInstanceOf(Matrix::class, $matrix);
        $this->assertSame(
            [
                [58, 64],
                [139, 154],
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
            Matrix::of([
                [1, 2],
                [3, 4],
            ])->isSquare()
        );
        $this->assertFalse(
            Matrix::of([
                [1, 2],
            ])->isSquare()
        );
    }

    public function testThrowWhenAskingForNonSquareDiagonal()
    {
        $this->expectException(MatrixMustBeSquare::class);

        Matrix::of([[1, 2]])->diagonal();
    }

    public function testDiagonal()
    {
        $matrix = Matrix::of($initial = [
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

    public function testThrowWhenAskingForNonSquareIdentity()
    {
        $this->expectException(MatrixMustBeSquare::class);

        Matrix::of([[1, 2]])->identity();
    }

    public function testIdentity()
    {
        $matrix = Matrix::of($initial = [
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

    public function testThrowWhenAddindMatricesOfDifferentDimensions()
    {
        $this->expectException(MatricesMustBeOfTheSameDimension::class);

        Matrix::of([[1]])->add(
            Matrix::of([[1, 2]])
        );
    }

    public function testAdd()
    {
        $a = Matrix::of($aValues = [
            [1, 0, -1],
            [2, 1, 4],
        ]);
        $b = Matrix::of($bValues = [
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

    public function testThrowWhenSubtractingMatricesOfDifferentDimensions()
    {
        $this->expectException(MatricesMustBeOfTheSameDimension::class);

        Matrix::of([[1]])->subtract(
            Matrix::of([[1, 2]])
        );
    }

    public function testSubtract()
    {
        $a = Matrix::of($aValues = [
            [1, 0, -1],
            [2, 1, 4],
        ]);
        $b = Matrix::of($bValues = [
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

    public function testMultiplyBy()
    {
        $matrix = Matrix::of($initial = [
            [1, 0, -1],
            [2, 3, 4],
        ]);
        $result = $matrix->multiplyBy(new Integer(3));

        $this->assertInstanceOf(Matrix::class, $result);
        $this->assertNotSame($matrix, $result);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame(
            [
                [3, 0, -3],
                [6, 9, 12],
            ],
            $result->toArray()
        );
    }

    public function testEquals()
    {
        $matrix = Matrix::of([
            [1, 0, -1],
            [2, 3, 4],
        ]);

        $this->assertTrue($matrix->equals($matrix));
        $this->assertTrue($matrix->equals(
            Matrix::of([
                [1, 0, -1],
                [2, 3, 4],
            ])
        ));
        $this->assertFalse($matrix->equals(
            Matrix::of([
                [2, 3, 4],
                [1, 0, -1],
            ])
        ));
        $this->assertFalse($matrix->equals($matrix->transpose()));
    }

    public function testIsSymmetric()
    {
        $matrix = Matrix::of([
            [1, 0, -1],
            [2, 3, 4],
        ]);

        $this->assertFalse($matrix->isSymmetric());

        $matrix = Matrix::of([
            [1, 0, 1],
            [0, 1, 0],
            [1, 0, 1],
        ]);

        $this->assertTrue($matrix->isSymmetric());
    }

    public function testIsAntisymmetric()
    {
        $matrix = Matrix::of([
            [1, 0, -1],
            [2, 3, 4],
        ]);

        $this->assertFalse($matrix->isAntisymmetric());

        $matrix = Matrix::of([
            [0, 2, 3, 4],
            [-2, 0, -1, 7],
            [-3, 1, 0, -6],
            [-4, -7, 6, 0],
        ]);

        $this->assertTrue($matrix->isAntisymmetric());
    }

    public function testIsInRowEchelonForm()
    {
        $matrix = Matrix::of([
            [3, 1, 1, -2, 1, 0, -3],
            [0, 0, 0, 3, 1, 1, 0],
            [0, 0, 0, 0, -1, 7, 9],
            [0, 0, 0, 0, 0, 2, 1],
            [0, 0, 0, 0, 0, 0, -3],
        ]);

        $this->assertTrue($matrix->isInRowEchelonForm());

        $matrix = Matrix::of([
            [3, 1, 1, -2, 1, 0, -3],
            [0, 0, 0, 3, 1, 1, 0],
            [0, 0, 0, 0, 0, 7, 9],
            [0, 0, 0, 0, 0, 2, 1],
            [0, 0, 0, 0, 0, 0, -3],
        ]);

        $this->assertFalse($matrix->isInRowEchelonForm());
    }

    public function testDropRow()
    {
        $matrix = Matrix::of($initial = [
            [0, 2, 3, 4],
            [-2, 0, -1, 7],
            [-3, 1, 0, -6],
            [-4, -7, 6, 0],
        ]);
        $dropped = $matrix->dropRow(0);

        $this->assertInstanceOf(Matrix::class, $dropped);
        $this->assertNotSame($matrix, $dropped);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame(
            [
                [-2, 0, -1, 7],
                [-3, 1, 0, -6],
                [-4, -7, 6, 0],
            ],
            $dropped->toArray()
        );
        $this->assertSame(
            [
                [0, 2, 3, 4],
                [-2, 0, -1, 7],
                [-4, -7, 6, 0],
            ],
            $matrix->dropRow(2)->toArray()
        );
    }

    public function testDropColumn()
    {
        $matrix = Matrix::of($initial = [
            [0, 2, 3, 4],
            [-2, 0, -1, 7],
            [-3, 1, 0, -6],
            [-4, -7, 6, 0],
        ]);
        $dropped = $matrix->dropColumn(0);

        $this->assertInstanceOf(Matrix::class, $dropped);
        $this->assertNotSame($matrix, $dropped);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame(
            [
                [2, 3, 4],
                [0, -1, 7],
                [1, 0, -6],
                [-7, 6, 0],
            ],
            $dropped->toArray()
        );
        $this->assertSame(
            [
                [0, 2, 4],
                [-2, 0, 7],
                [-3, 1, -6],
                [-4, -7, 0],
            ],
            $matrix->dropColumn(2)->toArray()
        );
    }

    public function testAugmentWith()
    {
        $matrix = Matrix::of($initial = [
            [2, 3, 4],
            [5, 6, 7],
            [8, 9, 10],
        ]);
        $augmented = $matrix->augmentWith($matrix->identity());

        $this->assertInstanceOf(Matrix::class, $augmented);
        $this->assertNotSame($matrix, $augmented);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame(
            [
                [2, 3, 4, 1, 0, 0],
                [5, 6, 7, 0, 1, 0],
                [8, 9, 10, 0, 0, 1],
            ],
            $augmented->toArray()
        );
    }

    /**
     * @dataProvider inverses
     */
    public function testInverse($initial, $expected)
    {
        $matrix = Matrix::of($initial);
        $inversed = $matrix->inverse();

        $this->assertInstanceOf(Matrix::class, $inversed);
        $this->assertNotSame($matrix, $inversed);
        $this->assertSame($initial, $matrix->toArray());
        $this->assertSame($expected, $inversed->toArray());
    }

    public function testThrowWhenTryingToInverseNonSquareMatrix()
    {
        $this->expectException(MatrixMustBeSquare::class);

        Matrix::of([
            [1, 2, 3],
            [4, 5, 6],
        ])->inverse();
    }

    public function testInverseIdentityProperty()
    {
        $matrix = Matrix::of($initial = [
            [1, 2, 1],
            [4, 0, -1],
            [-1, 2, 2],
        ]);

        $this->assertTrue(
            $matrix->dot($matrix->inverse())->equals(
                $matrix->identity()
            )
        );
    }

    public function testThrowWhenMatrixNotInvertible()
    {
        $this->expectException(MatrixNotInvertible::class);

        Matrix::of([
            [  2,   -3,    9,   -27,    81],
            [ -3,    9,  -27,    81,  -243],
            [  9,  -27,   81,  -243,   729],
            [-27,   81, -243,   729, -2187],
            [ 81, -243,  729, -2187,  6561],
        ])->inverse();
    }

    public function inverses(): array
    {
        return [
            [
                [
                    [1, 2, 1],
                    [4, 0, -1],
                    [-1, 2, 2],
                ],
                [
                    [-0.5, 0.5, 0.5],
                    [1.75, -0.75, -1.25],
                    [-2.0, 1.0, 2.0],
                ],
            ],
            [
                [
                    [1, 1, 1, 1],
                    [1, 2, 1, 1],
                    [2, 1, 1, 1],
                    [1, 1, 1, 2],
                ],
                [
                    [-1, 0, 1, 0],
                    [-1, 1, 0, 0],
                    [4, -1, -1, -1],
                    [-1, 0, 0, 1],
                ],
            ],
        ];
    }
}

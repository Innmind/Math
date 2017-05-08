<?php
declare(strict_types = 1);

namespace Innmind\Math;

use function Innmind\Math\{
    numerize,
    add
};
use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Absolute,
    Algebra\Ceil,
    Algebra\Division,
    Algebra\Floor,
    Algebra\Modulo,
    Algebra\Multiplication,
    Algebra\Power,
    Algebra\Round,
    Algebra\SquareRoot,
    Algebra\Subtraction,
    Geometry\Angle\Degree,
    Statistics\Frequence,
    Statistics\Mean,
    Statistics\Median,
    Statistics\Scope
};
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function testNumerize()
    {
        $numbers = numerize(
            1,
            4.2,
            $zero = new Number(0)
        );

        $this->assertCount(3, $numbers);
        $this->assertInstanceOf(NumberInterface::class, $numbers[0]);
        $this->assertInstanceOf(NumberInterface::class, $numbers[1]);
        $this->assertSame($zero, $numbers[2]);
        $this->assertSame(1, $numbers[0]->value());
        $this->assertSame(4.2, $numbers[1]->value());
    }

    public function testAdd()
    {
        $addition = add(1, 4.2, new Number(0));

        $this->assertInstanceOf(Addition::class, $addition);
        $this->assertSame(5.2, $addition->value());
    }

    public function testAbsolute()
    {
        $abs = \Innmind\Math\absolute(-4);

        $this->assertInstanceOf(Absolute::class, $abs);
        $this->assertSame(4, $abs->value());
    }

    public function testCeil()
    {
        $ceil = \Innmind\Math\ceil(4.2);

        $this->assertInstanceOf(Ceil::class, $ceil);
        $this->assertSame(5.0, $ceil->value());
    }

    public function testDivide()
    {
        $division = divide(8, 2);

        $this->assertInstanceOf(Division::class, $division);
        $this->assertSame(4, $division->value());
    }

    public function testFloor()
    {
        $floor = \Innmind\Math\floor(4.2);

        $this->assertInstanceOf(Floor::class, $floor);
        $this->assertSame(4.0, $floor->value());
    }

    public function testModulo()
    {
        $modulo = modulo(8, 1.5);

        $this->assertInstanceOf(Modulo::class, $modulo);
        $this->assertSame(0.5, $modulo->value());
    }

    public function testMultiply()
    {
        $multiplication = multiply(4, 2);

        $this->assertInstanceOf(Multiplication::class, $multiplication);
        $this->assertSame(8, $multiplication->value());
    }

    public function testPower()
    {
        $power = power(4, 2);

        $this->assertInstanceOf(Power::class, $power);
        $this->assertSame(16, $power->value());
    }

    public function testRound()
    {
        $round = \Innmind\Math\round(4.85, 1, 'down');

        $this->assertInstanceOf(Round::class, $round);
        $this->assertSame(4.8, $round->value());
    }

    public function testSquareRoot()
    {
        $squareRoot = squareRoot(4);

        $this->assertInstanceOf(SquareRoot::class, $squareRoot);
        $this->assertSame(2.0, $squareRoot->value());
    }

    public function testSubtract()
    {
        $subtraction = subtract(4, 2, 1);

        $this->assertInstanceOf(Subtraction::class, $subtraction);
        $this->assertSame(1, $subtraction->value());
    }

    /**
     * @dataProvider cosines
     */
    public function testCosine($expected, $number)
    {
        $cos = cosine($number);

        $this->assertInstanceOf(NumberInterface::class, $cos);
        $this->assertSame($expected->value(), $cos->value());
    }

    /**
     * @dataProvider sines
     */
    public function testSine($expected, $number)
    {
        $sin = sine($number);

        $this->assertInstanceOf(NumberInterface::class, $sin);
        $this->assertSame($expected->value(), $sin->value());
    }

    /**
     * @dataProvider tangents
     */
    public function testTangent($number)
    {
        $tan = tangent($number);

        $this->assertInstanceOf(NumberInterface::class, $tan);
        $this->assertSame(
            divide(sine($number), cosine($number))->value(),
            $tan->value()
        );
    }

    public function testFrequence()
    {
        $frequence = \Innmind\Math\frequence(1, 1, 2, 3, 4, 4);

        $this->assertInstanceOf(Frequence::class, $frequence);
        $this->assertSame(
            divide(2, 6)->value(),
            $frequence(new Number(1))->value()
        );
        $this->assertSame(
            divide(2, 6)->value(),
            $frequence(new Number(4))->value()
        );
        $this->assertSame(
            divide(1, 6)->value(),
            $frequence(new Number(2))->value()
        );
        $this->assertSame(
            divide(1, 6)->value(),
            $frequence(new Number(3))->value()
        );
    }

    public function testMean()
    {
        $mean = mean(1, 2, 2, 2, 3, 5, 5, 6, 6, 7);

        $this->assertInstanceOf(NumberInterface::class, $mean);
        $this->assertSame(3.9, $mean->value());
    }

    public function testMedian()
    {
        $median = median(1, 2, 2, 2, 3, 5, 5, 6, 6, 7);

        $this->assertInstanceOf(NumberInterface::class, $median);
        $this->assertSame(4, $median->value());
    }

    public function testScope()
    {
        $scope = scope(1, 2, 2, 2, 3, 5, 5, 6, 6, 7);

        $this->assertInstanceOf(NumberInterface::class, $scope);
        $this->assertSame(6, $scope->value());
    }

    public function cosines(): array
    {
        return [
            [divide(squareRoot(3), 2), 30],
            [divide(squareRoot(3), 2), 30.0],
            [divide(squareRoot(3), 2), new Number(30)],
            [divide(squareRoot(3), 2), new Degree(new Number(30))],
            [divide(squareRoot(3), 2), (new Degree(new Number(30)))->toRadian()],
        ];
    }

    public function sines(): array
    {
        return [
            [divide(squareRoot(3), 2), 60],
            [divide(squareRoot(3), 2), 60.0],
            [divide(squareRoot(3), 2), new Number(60)],
            [divide(squareRoot(3), 2), new Degree(new Number(60))],
            [divide(squareRoot(3), 2), (new Degree(new Number(60)))->toRadian()],
            [new Number(0.5), 30],
            [new Number(0.5), 30.0],
            [new Number(0.5), new Number(30)],
            [new Number(0.5), new Degree(new Number(30))],
            [new Number(0.5), (new Degree(new Number(30)))->toRadian()],
        ];
    }

    public function tangents(): array
    {
        return [
            [0],
            [30],
            [45],
            [60],
            [90],
        ];
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math;

use function Innmind\Math\{
    numerize,
    add,
    absolute,
    ceil as ceiling,
    cosine,
    divide,
    factorial,
    floor as floor_,
    frequence,
    mean,
    median,
    modulo,
    multiply,
    power,
    roundUp,
    roundDown,
    roundEven,
    roundOdd,
    sine,
    squareRoot,
    subtract,
    tangent,
    max as maximum,
    min as minimum,
    arcCosine,
    exponential,
    binaryLogarithm,
    naturalLogarithm,
    logarithm,
    commonLogarithm,
    signum,
    arcSine,
    arcTangent,
    toRadian,
    scope,
};
use Innmind\Math\{
    Algebra\Number,
    Algebra\Addition,
    Algebra\Absolute,
    Algebra\Ceil,
    Algebra\Division,
    Algebra\Floor,
    Algebra\Integer,
    Algebra\Modulo,
    Algebra\Multiplication,
    Algebra\Power,
    Algebra\Round,
    Algebra\SquareRoot,
    Algebra\Subtraction,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Geometry\Trigonometry\ArcCosine,
    Geometry\Trigonometry\ArcSine,
    Geometry\Trigonometry\ArcTangent,
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
            $zero = new Number\Number(0),
        );

        $this->assertCount(3, $numbers);
        $this->assertInstanceOf(Number::class, $numbers[0]);
        $this->assertInstanceOf(Number::class, $numbers[1]);
        $this->assertSame($zero, $numbers[2]);
        $this->assertSame(1, $numbers[0]->value());
        $this->assertSame(4.2, $numbers[1]->value());
    }

    public function testAdd()
    {
        $addition = add(1, 4.2, new Number\Number(0));

        $this->assertInstanceOf(Addition::class, $addition);
        $this->assertSame(5.2, $addition->value());
    }

    public function testAbsolute()
    {
        $abs = absolute(-4);

        $this->assertInstanceOf(Absolute::class, $abs);
        $this->assertSame(4, $abs->value());
    }

    public function testCeil()
    {
        $ceil = ceiling(4.2);

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
        $floor = floor_(4.2);

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
        $this->assertEquals(Round::up(new Number\Number(4.85), 1), roundUp(4.85, 1));
        $this->assertEquals(Round::down(new Number\Number(4.85), 1), roundDown(4.85, 1));
        $this->assertEquals(Round::even(new Number\Number(4.85), 1), roundEven(4.85, 1));
        $this->assertEquals(Round::odd(new Number\Number(4.85), 1), roundOdd(4.85, 1));
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

        $this->assertInstanceOf(Number::class, $cos);
        $this->assertSame($expected->value(), $cos->value());
    }

    public function testArcCosine()
    {
        $acos = arcCosine(cosine(30));

        $this->assertInstanceOf(ArcCosine::class, $acos);
        $this->assertSame(30.0, $acos->value());
    }

    public function testArcSine()
    {
        $asin = arcSine(sine(30));

        $this->assertInstanceOf(ArcSine::class, $asin);
        $this->assertSame(30.0, $asin->value());
    }

    public function testArcTangent()
    {
        $atan = arcTangent(tangent(30));

        $this->assertInstanceOf(ArcTangent::class, $atan);
        $this->assertSame(30.0, $atan->value());
    }

    /**
     * @dataProvider sines
     */
    public function testSine($expected, $number)
    {
        $sin = sine($number);

        $this->assertInstanceOf(Number::class, $sin);
        $this->assertSame($expected->value(), $sin->value());
    }

    /**
     * @dataProvider tangents
     */
    public function testTangent($number)
    {
        $tan = tangent($number);

        $this->assertInstanceOf(Number::class, $tan);
        $this->assertSame(
            divide(sine($number), cosine($number))->value(),
            $tan->value(),
        );
    }

    public function testFrequence()
    {
        $frequence = frequence(1, 1, 2, 3, 4, 4);

        $this->assertInstanceOf(Frequence::class, $frequence);
        $this->assertSame(
            divide(2, 6)->value(),
            $frequence(new Number\Number(1))->value(),
        );
        $this->assertSame(
            divide(2, 6)->value(),
            $frequence(new Number\Number(4))->value(),
        );
        $this->assertSame(
            divide(1, 6)->value(),
            $frequence(new Number\Number(2))->value(),
        );
        $this->assertSame(
            divide(1, 6)->value(),
            $frequence(new Number\Number(3))->value(),
        );
    }

    public function testMean()
    {
        $mean = mean(1, 2, 2, 2, 3, 5, 5, 6, 6, 7);

        $this->assertInstanceOf(Number::class, $mean);
        $this->assertSame(3.9, $mean->value());
    }

    public function testMedian()
    {
        $median = median(1, 2, 2, 2, 3, 5, 5, 6, 6, 7);

        $this->assertInstanceOf(Number::class, $median);
        $this->assertSame(4, $median->value());
    }

    public function testScope()
    {
        $scope = scope(1, 2, 2, 2, 3, 5, 5, 6, 6, 7);

        $this->assertInstanceOf(Number::class, $scope);
        $this->assertSame(6, $scope->value());
    }

    public function testFactorial()
    {
        $int = factorial(3);

        $this->assertInstanceOf(Number::class, $int);
        $this->assertSame(6, $int->value());
        $this->assertSame(24, factorial(new Integer(4))->value());
    }

    public function testMax()
    {
        $number = maximum(
            1,
            new Number\Number(2),
            $expected = new Number\Number(4),
            3,
        );

        $this->assertSame($expected, $number);
    }

    public function testMin()
    {
        $number = minimum(
            2,
            $expected = new Number\Number(1),
            new Number\Number(4),
            3,
        );

        $this->assertSame($expected, $number);
    }

    public function testExponential()
    {
        $exp = exponential(4);

        $this->assertInstanceOf(Exponential::class, $exp);
        $this->assertSame('e^4', $exp->toString());
    }

    public function testBinaryLogarithm()
    {
        $lb = binaryLogarithm(1);

        $this->assertInstanceOf(BinaryLogarithm::class, $lb);
        $this->assertSame('lb(1)', $lb->toString());
    }

    public function testNaturalLogarithm()
    {
        $ln = naturalLogarithm(1);

        $this->assertInstanceOf(NaturalLogarithm::class, $ln);
        $this->assertSame('ln(1)', $ln->toString());
    }

    public function testLogarithm()
    {
        $ln = logarithm(1);

        $this->assertInstanceOf(NaturalLogarithm::class, $ln);
        $this->assertSame('ln(1)', $ln->toString());
    }

    public function testCommonLogarithm()
    {
        $lg = commonLogarithm(1);

        $this->assertInstanceOf(CommonLogarithm::class, $lg);
        $this->assertSame('lg(1)', $lg->toString());
    }

    public function testSignum()
    {
        $sgn = signum(1);

        $this->assertInstanceOf(Signum::class, $sgn);
        $this->assertSame('sgn(1)', $sgn->toString());
    }

    public function testToRadian()
    {
        $radian = new Radian(new Number\Number(1));

        $this->assertSame($radian, toRadian($radian));
        $this->assertEquals($radian, toRadian(1));

        $degree = new Degree(new Number\Number(90));

        $this->assertEquals($degree->toRadian(), toRadian($degree));
    }

    public function cosines(): array
    {
        return [
            [divide(squareRoot(3), 2), 30],
            [divide(squareRoot(3), 2), 30.0],
            [divide(squareRoot(3), 2), new Number\Number(30)],
            [divide(squareRoot(3), 2), new Degree(new Number\Number(30))],
            [divide(squareRoot(3), 2), (new Degree(new Number\Number(30)))->toRadian()],
        ];
    }

    public function sines(): array
    {
        return [
            [divide(squareRoot(3), 2), 60],
            [divide(squareRoot(3), 2), 60.0],
            [divide(squareRoot(3), 2), new Number\Number(60)],
            [divide(squareRoot(3), 2), new Degree(new Number\Number(60))],
            [divide(squareRoot(3), 2), (new Degree(new Number\Number(60)))->toRadian()],
            [new Number\Number(0.5), 30],
            [new Number\Number(0.5), 30.0],
            [new Number\Number(0.5), new Number\Number(30)],
            [new Number\Number(0.5), new Degree(new Number\Number(30))],
            [new Number\Number(0.5), (new Degree(new Number\Number(30)))->toRadian()],
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

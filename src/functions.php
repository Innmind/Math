<?php
declare(strict_types = 1);

namespace Innmind\Math;

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
    Algebra\Factorial,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Geometry\Trigonometry\Cosine,
    Geometry\Trigonometry\ArcCosine,
    Geometry\Trigonometry\Sine,
    Geometry\Trigonometry\ArcSine,
    Geometry\Trigonometry\Tangent,
    Geometry\Trigonometry\ArcTangent,
    Statistics\Frequence,
    Statistics\Mean,
    Statistics\Median,
    Statistics\Scope,
};
use Innmind\Immutable\Sequence;

/**
 * @no-named-arguments
 * @psalm-pure
 */
function add(int|float|Number ...$numbers): Addition
{
    return new Addition(...numerize(...$numbers));
}

/**
 * @psalm-pure
 */
function absolute(int|float|Number $number): Number
{
    return new Absolute(numerize($number)[0]);
}

/**
 * @psalm-pure
 */
function ceil(int|float|Number $number): Number
{
    return new Ceil(numerize($number)[0]);
}

/**
 * @psalm-pure
 */
function divide(
    int|float|Number $dividend,
    int|float|Number $divisor,
): Number {
    return new Division(...numerize($dividend, $divisor));
}

/**
 * @psalm-pure
 */
function floor(int|float|Number $number): Number
{
    return new Floor(numerize($number)[0]);
}

/**
 * @psalm-pure
 */
function modulo(
    int|float|Number $number,
    int|float|Number $modulus,
): Number {
    return new Modulo(...numerize($number, $modulus));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function multiply(int|float|Number ...$numbers): Number
{
    return new Multiplication(...numerize(...$numbers));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function power(
    int|float|Number $number,
    int|float|Number $power,
): Number {
    return new Power(...numerize($number, $power));
}

/**
 * @psalm-pure
 */
function roundUp(int|float|Number $number, int $precision = 0): Number
{
    return Round::up(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @psalm-pure
 */
function roundDown(int|float|Number $number, int $precision = 0): Number
{
    return Round::down(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @psalm-pure
 */
function roundEven(int|float|Number $number, int $precision = 0): Number
{
    return Round::even(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @psalm-pure
 */
function roundOdd(int|float|Number $number, int $precision = 0): Number
{
    return Round::odd(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @psalm-pure
 */
function squareRoot(int|float|Number $number): Number
{
    return new SquareRoot(numerize($number)[0]);
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function subtract(int|float|Number ...$numbers): Subtraction
{
    return new Subtraction(...numerize(...$numbers));
}

/**
 * @psalm-pure
 */
function toDegree(Degree|Radian|int|float|Number $degree): Degree
{
    if ($degree instanceof Degree) {
        return $degree;
    }

    if ($degree instanceof Radian) {
        return $degree->toDegree();
    }

    return new Degree(numerize($degree)[0]);
}

/**
 * @psalm-pure
 */
function toRadian(Degree|Radian|int|float|Number $radian): Radian
{
    if ($radian instanceof Radian) {
        return $radian;
    }

    if ($radian instanceof Degree) {
        return $radian->toRadian();
    }

    return new Radian(numerize($radian)[0]);
}

/**
 * @psalm-pure
 */
function cosine(Degree|Radian|int|float|Number $degree): Number
{
    return new Cosine(toDegree($degree));
}

/**
 * @psalm-pure
 */
function arcCosine(int|float|Number $number): ArcCosine
{
    return new ArcCosine(...numerize($number));
}

/**
 * @psalm-pure
 */
function arcSine(int|float|Number $number): ArcSine
{
    return new ArcSine(...numerize($number));
}

/**
 * @psalm-pure
 */
function arcTangent(int|float|Number $number): ArcTangent
{
    return new ArcTangent(...numerize($number));
}

/**
 * @psalm-pure
 */
function sine(Degree|Radian|int|float|Number $degree): Number
{
    return new Sine(toDegree($degree));
}

/**
 * @psalm-pure
 */
function tangent(Degree|Radian|int|float|Number $degree): Number
{
    return new Tangent(toDegree($degree));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function frequence(int|float|Number ...$numbers): Frequence
{
    return new Frequence(...numerize(...$numbers));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function mean(
    int|float|Number $first,
    int|float|Number ...$numbers,
): Mean {
    return new Mean(...numerize($first, ...$numbers));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function median(
    int|float|Number $first,
    int|float|Number ...$numbers,
): Number {
    return new Median(...numerize($first, ...$numbers));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function scope(
    int|float|Number $first,
    int|float|Number $second,
    int|float|Number ...$numbers,
): Number {
    return new Scope(...numerize($first, $second, ...$numbers));
}

/**
 * @psalm-pure
 */
function factorial(int|Integer $int): Factorial
{
    if ($int instanceof Integer) {
        return $int->factorial();
    }

    return new Factorial($int);
}

/**
 * @psalm-pure
 */
function exponential(int|float|Number $number): Exponential
{
    return new Exponential(...numerize($number));
}

/**
 * @psalm-pure
 */
function binaryLogarithm(int|float|Number $number): BinaryLogarithm
{
    return new BinaryLogarithm(...numerize($number));
}

/**
 * @psalm-pure
 */
function naturalLogarithm(int|float|Number $number): NaturalLogarithm
{
    return new NaturalLogarithm(...numerize($number));
}

/**
 * @psalm-pure
 */
function logarithm(int|float|Number $number): NaturalLogarithm
{
    return naturalLogarithm($number);
}

/**
 * @psalm-pure
 */
function commonLogarithm(int|float|Number $number): CommonLogarithm
{
    return new CommonLogarithm(...numerize($number));
}

/**
 * @psalm-pure
 */
function signum(int|float|Number $number): Signum
{
    return new Signum(...numerize($number));
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function max(
    int|float|Number $first,
    int|float|Number ...$numbers,
): Number {
    $numbers = Sequence::of(...numerize($first, ...$numbers));

    return $numbers
        ->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $b->higherThan($a) ? 1 : -1;
        })
        ->first()
        ->match(
            static fn($max) => $max,
            static fn() => throw new \LogicException('Unreachable'),
        );
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function min(
    int|float|Number $first,
    int|float|Number ...$numbers,
): Number {
    $numbers = Sequence::of(...numerize($first, ...$numbers));

    return $numbers
        ->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $a->higherThan($b) ? 1 : -1;
        })
        ->first()
        ->match(
            static fn($min) => $min,
            static fn() => throw new \LogicException('Unreachable'),
        );
}

/**
 * @no-named-arguments
 * @psalm-pure
 *
 * @return list<Number>
 */
function numerize(int|float|Number ...$numbers): array
{
    return \array_map(
        static fn($number): Number => $number instanceof Number ? $number : Number\Number::of($number),
        $numbers,
    );
}

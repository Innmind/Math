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
 *
 * @param int|float|Number $numbers
 */
function add(...$numbers): Addition
{
    return new Addition(...numerize(...$numbers));
}

/**
 * @param int|float|Number $number
 */
function absolute($number): Number
{
    return new Absolute(numerize($number)[0]);
}

/**
 * @param int|float|Number $number
 */
function ceil($number): Number
{
    return new Ceil(numerize($number)[0]);
}

/**
 * @param int|float|Number $dividend
 * @param int|float|Number $divisor
 */
function divide($dividend, $divisor): Number
{
    return new Division(...numerize($dividend, $divisor));
}

/**
 * @param int|float|Number $number
 */
function floor($number): Number
{
    return new Floor(numerize($number)[0]);
}

/**
 * @param int|float|Number $number
 * @param int|float|Number $modulus
 */
function modulo($number, $modulus): Number
{
    return new Modulo(...numerize($number, $modulus));
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $numbers
 */
function multiply(...$numbers): Number
{
    return new Multiplication(...numerize(...$numbers));
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $number
 * @param int|float|Number $power
 */
function power($number, $power): Number
{
    return new Power(...numerize($number, $power));
}

/**
 * @param int|float|Number $number
 */
function roundUp($number, int $precision = 0): Number
{
    return Round::up(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @param int|float|Number $number
 */
function roundDown($number, int $precision = 0): Number
{
    return Round::down(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @param int|float|Number $number
 */
function roundEven($number, int $precision = 0): Number
{
    return Round::even(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @param int|float|Number $number
 */
function roundOdd($number, int $precision = 0): Number
{
    return Round::odd(
        numerize($number)[0],
        $precision,
    );
}

/**
 * @param int|float|Number $number
 */
function squareRoot($number): Number
{
    return new SquareRoot(numerize($number)[0]);
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $numbers
 */
function subtract(...$numbers): Subtraction
{
    return new Subtraction(...numerize(...$numbers));
}

/**
 * @param Degree|Radian|int|float|Number $degree
 */
function toDegree($degree): Degree
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
 * @param Degree|Radian|int|float|Number $radian
 */
function toRadian($radian): Radian
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
 * @param Degree|Radian|int|float|Number $degree
 */
function cosine($degree): Number
{
    return new Cosine(toDegree($degree));
}

/**
 * @param int|float|Number $number
 */
function arcCosine($number): ArcCosine
{
    return new ArcCosine(...numerize($number));
}

/**
 * @param int|float|Number $number
 */
function arcSine($number): ArcSine
{
    return new ArcSine(...numerize($number));
}

/**
 * @param int|float|Number $number
 */
function arcTangent($number): ArcTangent
{
    return new ArcTangent(...numerize($number));
}

/**
 * @param Degree|Radian|int|float|Number $degree
 */
function sine($degree): Number
{
    return new Sine(toDegree($degree));
}

/**
 * @param Degree|Radian|int|float|Number $degree
 */
function tangent($degree): Number
{
    return new Tangent(toDegree($degree));
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $numbers
 */
function frequence(...$numbers): Frequence
{
    return new Frequence(...numerize(...$numbers));
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 */
function mean($first, ...$numbers): Mean
{
    return new Mean(...numerize($first, ...$numbers));
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 */
function median($first, ...$numbers): Number
{
    return new Median(...numerize($first, ...$numbers));
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $first
 * @param int|float|Number $second
 * @param int|float|Number $numbers
 */
function scope($first, $second, ...$numbers): Number
{
    return new Scope(...numerize($first, $second, ...$numbers));
}

/**
 * @param int|Integer $int
 */
function factorial($int): Factorial
{
    if ($int instanceof Integer) {
        return $int->factorial();
    }

    return new Factorial($int);
}

/**
 * @param int|float|Number $number
 */
function exponential($number): Exponential
{
    return new Exponential(...numerize($number));
}

/**
 * @param int|float|Number $number
 */
function binaryLogarithm($number): BinaryLogarithm
{
    return new BinaryLogarithm(...numerize($number));
}

/**
 * @param int|float|Number $number
 */
function naturalLogarithm($number): NaturalLogarithm
{
    return new NaturalLogarithm(...numerize($number));
}

/**
 * @param int|float|Number $number
 */
function logarithm($number): NaturalLogarithm
{
    return naturalLogarithm($number);
}

/**
 * @param int|float|Number $number
 */
function commonLogarithm($number): CommonLogarithm
{
    return new CommonLogarithm(...numerize($number));
}

/**
 * @param int|float|Number $number
 */
function signum($number): Signum
{
    return new Signum(...numerize($number));
}

/**
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 */
function max($first, ...$numbers): Number
{
    $numbers = Sequence::of(Number::class, ...numerize($first, ...$numbers));

    return $numbers
        ->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $b->higherThan($a) ? 1 : -1;
        })
        ->first();
}

/**
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 */
function min($first, ...$numbers): Number
{
    $numbers = Sequence::of(Number::class, ...numerize($first, ...$numbers));

    return $numbers
        ->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $a->higherThan($b) ? 1 : -1;
        })
        ->first();
}

/**
 * @no-named-arguments
 *
 * @param int|float|Number $numbers
 *
 * @return list<Number>
 */
function numerize(...$numbers): array
{
    return \array_map(
        static fn($number): Number => $number instanceof Number ? $number : Number\Number::wrap($number),
        $numbers,
    );
}

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
    Statistics\Scope
};
use Innmind\Immutable\Sequence;

/**
 * @param int|float|Number $numbers
 */
function add(...$numbers): Number
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
 * @param int|float|Number $numbers
 */
function multiply(...$numbers): Number
{
    return new Multiplication(...numerize(...$numbers));
}

/**
 * @param int|float|Number $number
 * @param int|float|Number $power
 */
function power($number, $power): Number
{
    return new Power(...numerize($number, $power));
}

/**
 * @param int|float|Number $number
 * @param int|float|Number $precision
 * @param string $mode
 */
function round($number, $precision = 0, $mode = Round::UP): Number
{
    return new Round(
        numerize($number)[0],
        $precision,
        strtoupper($mode)
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
 * @param int|float|Number $numbers
 */
function subtract(...$numbers): Number
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
 * @param int|float|Number $numbers
 */
function frequence(...$numbers): Frequence
{
    return new Frequence(...numerize(...$numbers));
}

/**
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 */
function mean($first, ...$numbers): Number
{
    return new Mean(...numerize($first, ...$numbers));
}

/**
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 */
function median($first, ...$numbers): Number
{
    return new Median(...numerize($first, ...$numbers));
}

/**
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
 *
 * @return Factorial
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
 *
 * @return Exponential
 */
function exponential($number): Exponential
{
    return new Exponential(...numerize($number));
}

/**
 * @param int|float|Number $number
 *
 * @return BinaryLogarithm
 */
function binaryLogarithm($number): BinaryLogarithm
{
    return new BinaryLogarithm(...numerize($number));
}

/**
 * @param int|float|Number $number
 *
 * @return NaturalLogarithm
 */
function naturalLogarithm($number): NaturalLogarithm
{
    return new NaturalLogarithm(...numerize($number));
}

/**
 * @param int|float|Number $number
 *
 * @return NaturalLogarithm
 */
function logarithm($number): NaturalLogarithm
{
    return naturalLogarithm($number);
}

/**
 * @param int|float|Number $number
 *
 * @return CommonLogarithm
 */
function commonLogarithm($number): CommonLogarithm
{
    return new CommonLogarithm(...numerize($number));
}

/**
 * @param int|float|Number $number
 *
 * @return Signum
 */
function signum($number): Signum
{
    return new Signum(...numerize($number));
}

/**
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 *
 * @return Number
 */
function max($first, ...$numbers): Number
{
    return (new Sequence(...numerize($first, ...$numbers)))
        ->sort(static function(Number $a, Number $b) {
            return $b->higherThan($a);
        })
        ->first();
}

/**
 * @param int|float|Number $first
 * @param int|float|Number $numbers
 *
 * @return Number
 */
function min($first, ...$numbers): Number
{
    return (new Sequence(...numerize($first, ...$numbers)))
        ->sort(static function(Number $a, Number $b) {
            return $a->higherThan($b);
        })
        ->first();
}

/**
 * @param int|float|Number $numbers
 *
 * @return Number[]
 */
function numerize(...$numbers): array
{
    foreach ($numbers as &$number) {
        if ($number instanceof Number) {
            continue;
        }

        $number = Number\Number::wrap($number);
    }

    return $numbers;
}

<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\{
    Algebra\NumberInterface,
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
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Geometry\Trigonometry\Cosine,
    Geometry\Trigonometry\Sine,
    Geometry\Trigonometry\Tangent,
    Statistics\Frequence,
    Statistics\Mean,
    Statistics\Median,
    Statistics\Scope
};
use Innmind\Immutable\Sequence;

/**
 * @param int|float|NumberInterface $numbers
 */
function add(...$numbers): NumberInterface
{
    return new Addition(...numerize(...$numbers));
}

/**
 * @param int|float|NumberInterface $number
 */
function absolute($number): NumberInterface
{
    return new Absolute(numerize($number)[0]);
}

/**
 * @param int|float|NumberInterface $number
 */
function ceil($number): NumberInterface
{
    return new Ceil(numerize($number)[0]);
}

/**
 * @param int|float|NumberInterface $dividend
 * @param int|float|NumberInterface $divisor
 */
function divide($dividend, $divisor): NumberInterface
{
    return new Division(...numerize($dividend, $divisor));
}

/**
 * @param int|float|NumberInterface $number
 */
function floor($number): NumberInterface
{
    return new Floor(numerize($number)[0]);
}

/**
 * @param int|float|NumberInterface $number
 * @param int|float|NumberInterface $modulus
 */
function modulo($number, $modulus): NumberInterface
{
    return new Modulo(...numerize($number, $modulus));
}

/**
 * @param int|float|NumberInterface $numbers
 */
function multiply(...$numbers): NumberInterface
{
    return new Multiplication(...numerize(...$numbers));
}

/**
 * @param int|float|NumberInterface $number
 * @param int|float|NumberInterface $power
 */
function power($number, $power): NumberInterface
{
    return new Power(...numerize($number, $power));
}

/**
 * @param int|float|NumberInterface $number
 * @param int|float|NumberInterface $precision
 * @param string $mode
 */
function round($number, $precision = 0, $mode = Round::UP): NumberInterface
{
    return new Round(
        numerize($number)[0],
        $precision,
        strtoupper($mode)
    );
}

/**
 * @param int|float|NumberInterface $number
 */
function squareRoot($number): NumberInterface
{
    return new SquareRoot(numerize($number)[0]);
}

/**
 * @param int|float|NumberInterface $numbers
 */
function subtract(...$numbers): NumberInterface
{
    return new Subtraction(...numerize(...$numbers));
}

/**
 * @param Degree|Radian|int|float|NumberInterface $degree
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
 * @param Degree|Radian|int|float|NumberInterface $radian
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
 * @param Degree|Radian|int|float|NumberInterface $degree
 */
function cosine($degree): NumberInterface
{
    return (new Cosine(toDegree($degree)))();
}

/**
 * @param Degree|Radian|int|float|NumberInterface $degree
 */
function sine($degree): NumberInterface
{
    return (new Sine(toDegree($degree)))();
}

/**
 * @param Degree|Radian|int|float|NumberInterface $degree
 */
function tangent($degree): NumberInterface
{
    return (new Tangent(toDegree($degree)))();
}

/**
 * @param int|float|NumberInterface $numbers
 */
function frequence(...$numbers): Frequence
{
    return new Frequence(...numerize(...$numbers));
}

/**
 * @param int|float|NumberInterface $first
 * @param int|float|NumberInterface $numbers
 */
function mean($first, ...$numbers): NumberInterface
{
    return new Mean(...numerize($first, ...$numbers));
}

/**
 * @param int|float|NumberInterface $first
 * @param int|float|NumberInterface $numbers
 */
function median($first, ...$numbers): NumberInterface
{
    return new Median(...numerize($first, ...$numbers));
}

/**
 * @param int|float|NumberInterface $first
 * @param int|float|NumberInterface $second
 * @param int|float|NumberInterface $numbers
 */
function scope($first, $second, ...$numbers): NumberInterface
{
    return new Scope(...numerize($first, $second, ...$numbers));
}

/**
 * @param int|Integer $int
 *
 * @return NumberInterface
 */
function factorial($int): NumberInterface
{
    if (!$int instanceof Integer) {
        $int = new Integer($int);
    }

    return $int->factorial();
}

/**
 * @param int|float|NumberInterface $first
 * @param int|float|NumberInterface $numbers
 *
 * @return NumberInterface
 */
function max($first, ...$numbers): NumberInterface
{
    return (new Sequence(...numerize($first, ...$numbers)))
        ->sort(function(NumberInterface $a, NumberInterface $b) {
            return $b->higherThan($a);
        })
        ->first();
}

/**
 * @param int|float|NumberInterface $first
 * @param int|float|NumberInterface $numbers
 *
 * @return NumberInterface
 */
function min($first, ...$numbers): NumberInterface
{
    return (new Sequence(...numerize($first, ...$numbers)))
        ->sort(function(NumberInterface $a, NumberInterface $b) {
            return $a->higherThan($b);
        })
        ->first();
}

/**
 * @param int|float|NumberInterface $numbers
 *
 * @return NumberInterface[]
 */
function numerize(...$numbers): array
{
    foreach ($numbers as &$number) {
        if ($number instanceof NumberInterface) {
            continue;
        }

        $number = new Number($number);
    }

    return $numbers;
}

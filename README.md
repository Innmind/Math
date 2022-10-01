# Math

[![Build Status](https://github.com/innmind/math/workflows/CI/badge.svg?branch=master)](https://github.com/innmind/math/actions?query=workflow%3ACI)
[![codecov](https://codecov.io/gh/innmind/math/branch/develop/graph/badge.svg)](https://codecov.io/gh/innmind/math)
[![Type Coverage](https://shepherd.dev/github/innmind/math/coverage.svg)](https://shepherd.dev/github/innmind/math)

Expose some math concepts as objects.

**Note**: all classes are immutable.

## Algebra

```php
use Innmind\Math\Algebra\{
    Value,
    Integer,
};

$perimeter = Value::two->multiplyBy(Value::pi, $r = Integer::of(42)); // value still not calculated
echo $perimeter->toString(); // 2 x π x 42 (value still not calculated)
echo $perimeter->value(); // 263.89378290154
```

By doing math like this you calculate the data that's really needed, so if you pass around a variable but never check it's content then it will never be calculated. The other advantage is that by casting to a string an operation you can see what the operation steps are (might be helpful for debugging a function operation).

**Note**: by calling `collapse` on a `Number` it will try to optimize some calculations such as `squareRoot(square(x))` will directly return `x` thus avoiding rounding errors.

## Definition sets

```php
use Innmind\Math\{
    DefinitionSet\Range,
    Algebra\Integer,
    Algebra\Value,
};

$set = Range::exlusive(Value::zero, Value::infinite);
echo $set->toString(); // ]0;+∞[
$set->contains(Integer::of(42)); // true
$set->contains(Integer::of(-42)); // false

$set = $set->union(
    Range::exclusive(Value::negativeInfinite, Value::zero),
);
echo $set; // ]-∞;0[∪]0;+∞[
$set->contains(Integer::of(-42)); // true
$set->contains(Integer::of(0)); // false
```

## Polynom

```php
use Innmind\Math\Polynom\Polynom;

$p = Polynom::interceptAt($intercept = Integer::of(1))
    ->withDegree(Integer::of(1), new Number(0.5))
    ->withDegree(Integer::of(2), new Number(0.1));
$p(Integer::of(4))->value(); // 4.6
echo $p->toString(); // 0.1x^2 + 0.5x + 1
```

You also can call the `derived` number for any point `x` (as well as the `tangent`). You can have access to the `primitive` and `derivative` of the polynom, the last one is notably used to calculate an `Integral`.

```php
use Innmind\Math\Polynom\Integral;

$integral = Integral::of($somePolynom);
$area = $integral(Integer::of(0), new Integral(42)); // find the area beneath the curve between point 0 and 42
echo $integral->toString(); // ∫(-1x^2 + 4x)dx = [(-1 ÷ (2 + 1))x^3 + (4 ÷ (1 + 1))x^2] (if the polynom is -1x^2 + 4x)
```

## Regression

### Polynomial Regression

```php
use Innmind\Math\{
    Regression\PolynomialRegression,
    Regression\Dataset,
    Algebra\Integer,
};

$regression = PolynomialRegression::of(
    Dataset::of([
        [-8, 64],
        [-4, 16],
        [0, 0],
        [2, 4],
        [4, 16],
        [8, 64],
    ]),
);
// so in essence it found x^2
$regression(Integer::of(9))->value(); // 81.0
```

### Linear regression

```php
use Innmind\Math\{
    Regression\LinearRegression,
    Regression\Dataset,
    Algebra\Integer;
};

$r = LinearRegression::of(Dataset::of([
    [0, 0],
    [1, 1],
    [2, 0],
    [3, 2],
]));
$r->intercept()->value(); // 0.0
$r->slope()->value(); // 0.5
$r(Integer::of(4))->value(); // 2.0
```

## Probabilities

```php
use Innmind\Math\{
    Regression\Dataset,
    Probabilities\Expectation,
    Probabilities\StandardDeviation,
    Probabilities\Variance,
};

$dataset = Dataset::of([
    [-1, 4/6], // 4 6th of a chance to obtain a -1
    [2, 1/6],
    [3, 1/6],
]);
echo Expectation::of($dataset)()->value(); //0,1666666667 (1 6th)
echo StandardDeviation::of($dataset)()->value(); //√(101/36)
echo Variance::of($dataset)()->value(); //101/36
```

## Quantile

```php
use Innmind\Math\Quantile\Quantile;
use Innmind\Immutable\Sequence;

$q = Quantile::of(Sequence::of(...\range(1,12)));
$q->min()->value(); // 1
$q->max()->value(); // 12
$q->mean(); // 6.5
$q->median()->value(); // 6.5
$q->quartile(1)->value(); // 3.5 because 25% of values from the set are lower than 3.5
$q->quartile(3)->value(); // 9.5 because 75% of values from the set are lower than 9.5
```

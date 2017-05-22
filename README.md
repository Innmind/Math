# Math

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Math/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Math/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Math/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Math/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/Math/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Math/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/Math/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/build-status/develop) |

Expose some math concepts as objects.

## Algebra

```php
use function Innmind\Math\multiply;
use Innmind\Math\Algebra\Number\Pi;

$perimeter = multiply(2, new Pi, $r = 42); //value still not calculated
echo $perimeter; //2 x π x 42 (value still not calculated)
echo $perimeter->value(); //263.89378290154
```

By doing math like this you calculate the data that's really needed, so if you pass around a variable but never check it's content then it will never be calculated. The other advantage is that by casting to a string an operation you can see what the operation steps are (might be helpful for debugging a function operation).

Have a look at the [`functions`](src/functions.php) file to see all the operations available.

## Definition sets

```php
use Innmind\Math\{
    DefinitionSet\Range,
    Algebra\Integer,
    Algebra\Number\Infinite
};

$set = Range::exlusive(new Integer(0), Infinite::positive());
echo $set; //]0;+∞[
$set->contains(new Integer(42)); //true
$set->contains(new Integer(-42)); //false

$set = $set->union(
    Range::exclusive(Infinite::negative(), new Integer(0))
);
echo $set; //]-∞;0[∪]0;+∞[
$set->contains(new Integer(-42)); //true
$set->contains(new Integer(0)); //false
```

## Polynom

```php
use Innmind\Math\Polynom\Polynom;

$p = (new Polynom($intercept = new Integer(1)))
    ->withDegree(new Integer(1), new Number(0.5))
    ->withDegree(new Integer(2), new Number(0.1));
$p->intercept()->value(); // 1
$p->degree(1)->coeff()->value(); // 0.5
$p->degree(2)->coeff()->value(); // 0.1
$p->hasDegree(3); // false
$p(new Integer(4))->value(); // 4.6
echo $p; //0.1x^2 + 0.5x + 1
```

You also can call the `derived` number for any point `x` (as well as the `tangent`). You can have access to the `primitive` and `derivative` of the polynom, the last one is notably used to calculate an `Integral`.

```php
use Innmind\Math\Polynom\Integral;

$integral = new Integral($somePolynom);
$area = $integral(new Integer(0), new Integral(42)); //find the area beneath the curve between point 0 and 42
echo $integral; //∫(-1x^2 + 4x)dx = [(-1 ÷ (2 + 1))x^3 + (4 ÷ (1 + 1))x^2] (if the polynom is -1x^2 + 4x)
```

**Note**: a `Polynom` object is immutable, and so calling `withDegree` return a new instance. If you want to ommit intermediates object, you can pass a list of [`Degree`](src/Polynom/Degree.php) objects after the intercept.

## Regression

### Polynomial Regression

```php
use Innmind\Math\{
    Regression\PolynomialRegression,
    Regression\Dataset,
    Algebra\Integer
};

$regression = new PolynomialRegression(
    Dataset::fromArray([
        [-8, 64],
        [-4, 16],
        [0, 0],
        [2, 4],
        [4, 16],
        [8, 64],
    ])
);
$regression->intercept()->value(); //≈ 0.0
$regression->degree(1)->coeff()->value(); //≈0.0
$regression->degree(2)->coeff()->value(); //1.0
//so in essence it found x^2
$regression(new Integer(9))->value(); //81.0
```

### Linear regression

```php
use Innmind\Math\{
    Regression\LinearRegression,
    Regression\Dataset,
    Algebra\Integer
};

$r = new LinearRegression(Dataset::fromArray([0, 1, 0, 2]));
$r->intercept()->value(); // 0.0
$r->slope()->value(); // 0.5
$r(new Integer(4))->value(); // 2.0
```

## Probabilities

```php
use Innmind\Math\{
    Regression\Dataset,
    Probabilities\Expectation,
    Probabilities\StandardDeviation,
    Probabilities\Variance
};

$dataset = Dataset::fromArray([
    [-1, 4/6], //4 6th of a chance to obtain a -1
    [2, 1/6],
    [3, 1/6],
]);
echo (new Expectation($dataset))()->value(); //0,1666666667 (1 6th)
echo (new StandardDeviation($dataset))()->value(); //√(101/36)
echo (new Variance($dataset))()->value(); //101/36
```

## Quantile

```php
use Innmind\Math\{
    Quantile\Quantile,
    Regression\Dataset
};

$q = new Quantile(Dataset::fromArray(range(1,12)));
$q->min()->value(); // 1
$q->max()->value(); // 12
$q->mean(); // 6.5
$q->median()->value(); // 6.5
$q->quartile(1)->value(); // 3.5 because 25% of values from the set are lower than 3.5
$q->quartile(3)->value(); // 9.5 because 75% of values from the set are lower than 9.5
```

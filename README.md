# Math

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Math/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Math/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Math/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Math/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/Math/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Math/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/Math/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/build-status/develop) |

## Quantile

```php
use Innmind\Math\Quantile\Quantile;

$q = new Quantile(range(1,12));
$q->min()->value(); // 1
$q->max()->value(); // 12
$q->mean(); // 6.5
$q->median()->value(); // 6.5
$q->quartile(1)->value(); // 3.5 because 25% of values from the set are lower than 3.5
$q->quartile(3)->value(); // 9.5 because 75% of values from the set are lower than 9.5
```

## Linear regression

```php
use Innmind\Math\Regression\LinearRegression;

$r = new LinearRegression([0, 1, 0, 2]);
$r->intercept(); // 0.0
$r->slope(); // 0.5
$r(4); // 2.0
```

## Polynom

```php
use Innmind\Math\Polynom\Polynom;

$p = (new Polynom($intercept = 1))
    ->withDegree(1, 0.5)
    ->withDegree(2, 0.1);
$p->intercept(); // 1
$p->degree(1)->coeff(); // 0.5
$p->degree(2)->coeff(); // 0.1
$p->hasDegree(3); // false
$p(4); // 4.6
```
The above object represent the given math formulae: 1 + 0.5*X + 0.1*X<sup>2</sup>

**Note**: a `Polynom` object is immutable, and so calling `withDegree` return a new instance. If you want to ommit intermediates object, you can pass a list of [`Degree`](Polynom/Degree.php) objects as the second argument of `Polynom`.

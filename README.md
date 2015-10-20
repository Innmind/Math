# Math

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Math/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Math/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/g/Innmind/Math/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Math/build-status/develop)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0d40ca0-ff10-42ac-93c2-f9fd281ef545/big.png)](https://insight.sensiolabs.com/projects/e0d40ca0-ff10-42ac-93c2-f9fd281ef545)

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

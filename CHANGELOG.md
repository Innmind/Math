# Changelog

## 7.0.0 - 2026-02-14

### Added

- `Innmind\Math\Algebra\Number::apply()`
- `Innmind\Math\Algebra\Number::as()`
- `Innmind\Math\Algebra\Number::memoize()`
- `Innmind\Math\Algebra\Number::optimize()`
- `Innmind\Math\Algebra\Func`
- `Innmind\Math\Algebra\Logarithm`
- `Innmind\Math\Geometry\Trigonometry`
- `Innmind\Math\Geometry\Angle\Degree::cosine()`
- `Innmind\Math\Geometry\Angle\Degree::sine()`
- `Innmind\Math\Geometry\Angle\Degree::tangent()`
- `Innmind\Math\Geometry\Angle\Radian::cosine()`
- `Innmind\Math\Geometry\Angle\Radian::sine()`
- `Innmind\Math\Geometry\Angle\Radian::tangent()`
- `Innmind\Math\Polynom\Degree::is()`

### Changed

- Requires PHP `8.4`
- `Innmind\Math\DefinitionSet\Set` is now a final class, all previous implementations are now flagged as internal
- `Innmind\Math\Monoid\*` are now enums
    - `Addition` is now accessible via `Algebra::addition`
    - `Multiplication` is now accessible via `Algebra::multiplication`
- `Innmind\Math\Probabilities\BinomialDistribution::__invoke()` arguments now expects `int`s
- `Innmind\Math\Algebra\Number` is now a final class, all previous implementations are now flagged as internal
- Requires `innmind/immutable:~6.0`
- `Innmind\Math\Geometry\*` methods are no longer prefixed with `is`
- `Innmind\Math\DefinitionSet\Set::accept()` now returns an `Innmind\Immutable\Attempt<SideEffect>`
- `Innmind\Math\Matrix` methods are no longer prefixed with `is`

### Fixed

- PHP `8.4` deprecations

### Removed

- `Innmind\Math\Algebra\Operation`
- The possibility to specify multiple values to `Innmind\Math\Algebra\Number::add()`, `::multiplyBy()` and `::subtract()`
- `Innmind\Math\Geometry\Trigonometry\ArcCosine`
- `Innmind\Math\Geometry\Trigonometry\ArcSine`
- `Innmind\Math\Geometry\Trigonometry\ArcTangent`
- `Innmind\Math\Geometry\Trigonometry\Cosine`
- `Innmind\Math\Geometry\Trigonometry\Sine`
- `Innmind\Math\Geometry\Trigonometry\Tangent`
- `Innmind\Math\Algebra\Number::binaryLogarithm()`, use `->apply(Logarithm::binary)` instead
- `Innmind\Math\Algebra\Number::commonLogarithm()`, use `->apply(Logarithm::common)` instead
- `Innmind\Math\Algebra\Number::naturalLogarithm()`, use `->apply(Logarithm::natural)` instead
- `Innmind\Math\Algebra\Number::collapse()`, use `->optimize()->memoize()` instead

## 6.1.0 - 2023-09-23

### Added

- Support for `innmind/immutable:~5.0`

### Removed

- Support for PHP `8.1`

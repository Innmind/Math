# Changelog

## [Unreleased]

### Changed

- Requires PHP `8.4`
- `Innmind\Math\DefinitionSet\Set` is now a final class, all previous implementations are now flagged as internal
- `Innmind\Math\Monoid\*` are now enums
- `Innmind\Math\Probabilities\BinomialDistribution::__invoke()` arguments now expects `int`s

### Fixed

- PHP `8.4` deprecations

### Removed

- `Innmind\Math\Algebra\Operation`

## 6.1.0 - 2023-09-23

### Added

- Support for `innmind/immutable:~5.0`

### Removed

- Support for PHP `8.1`

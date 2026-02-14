<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class AppliedFunc implements Implementation
{
    private function __construct(
        private Func $func,
        private Number $x,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Func $func, Number $x): self
    {
        return new self($func, $x);
    }

    #[\Override]
    public function raw(): Native|Value
    {
        $result = ($this->func)($this->x);

        /**
         * @psalm-suppress PossiblyNullFunctionCall
         * @psalm-suppress ImpureFunctionCall
         * @psalm-suppress MixedReturnStatement
         * @psalm-suppress InaccessibleProperty
         */
        return (\Closure::bind(
            static fn(Number $result) => $result->implementation->raw(),
            null,
            Number::class,
        ))($result);
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return new self(
            $this->func,
            $this->x->optimize(),
        );
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf(
            '%s(%s)',
            $this->func->name(),
            $this->x->toString(),
        );
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}

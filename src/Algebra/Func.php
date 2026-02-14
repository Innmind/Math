<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
interface Func
{
    #[\NoDiscard]
    public function __invoke(Number $x): Number;

    /**
     * @return non-empty-string
     */
    #[\NoDiscard]
    public function name(): string;
}

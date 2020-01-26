<?php
declare(strict_types = 1);

namespace Innmind\Math\Exception;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
};

final class OutOfDefinitionSet extends LogicException
{
    public function __construct(Set $set, Number $number)
    {
        parent::__construct($number->toString().' ∉ '.$set->toString());
    }
}

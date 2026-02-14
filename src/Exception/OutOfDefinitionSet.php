<?php
declare(strict_types = 1);

namespace Innmind\Math\Exception;

use Innmind\Math\{
    DefinitionSet\Implementation,
    Algebra\Number,
};

final class OutOfDefinitionSet extends LogicException
{
    public function __construct(Implementation $set, Number $number)
    {
        parent::__construct($number->toString().' ∉ '.$set->toString());
    }
}

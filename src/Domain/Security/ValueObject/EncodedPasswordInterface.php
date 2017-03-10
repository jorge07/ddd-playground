<?php

namespace Leos\Domain\Security\ValueObject;

/**
 * Interface EncodedPasswordInterface
 *
 * @package Leos\Domain\Security\ValueObject
 */
interface EncodedPasswordInterface
{
    public function __construct(string $plainPassword);

    public function __toString(): string;
}

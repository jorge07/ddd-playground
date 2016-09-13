<?php

namespace Leos\Domain\Security\ValueObject;

/**
 * Interface EncodedPasswordInterface
 *
 * @package Leos\Domain\Security\ValueObject
 */
interface EncodedPasswordInterface
{
    /**
     * EncodedPasswordInterface constructor.
     * 
     * @param string $plainPassword
     */
    public function __construct(string $plainPassword);

    /**
     * @return string
     */
    public function __toString(): string;
}

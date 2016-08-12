<?php
declare(strict_types=1);

namespace Leos\Domain\Common\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * Class AggregateRootId
 *
 * Its the unique identifier and will be auto-generated if not value is set.
 *
 * @package Leos\Domain\Common\ValueObject
 */
abstract class AggregateRootId
{
    /**
     * @var string
     */
    protected $id;

    /**
     * AggregateRootId constructor.
     *
     * @param null|string $id
     */
    public function __construct(string $id = null)
    {
        $this->id = (string) Uuid::fromString($id ?: Uuid::uuid4());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->id;
    }
}

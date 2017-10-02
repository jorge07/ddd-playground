<?php

namespace Leos\Domain\Common\Event;

interface EventStoreInterface
{
    public function event(): EventInterface;

    public function type(): string;

    public function createdAt(): \DateTimeImmutable;
}

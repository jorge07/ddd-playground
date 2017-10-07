<?php

namespace Leos\Infrastructure\CommonBundle\Repository;

use Leos\Infrastructure\CommonBundle\Doctrine\ORM\Repository\EntityRepository;
use Leos\Infrastructure\CommonBundle\Event\EventAware;

class EventStoreRepository extends EntityRepository
{

    public function store(EventAware $eventAware)
    {
        $this->_em->persist($eventAware);
    }
}

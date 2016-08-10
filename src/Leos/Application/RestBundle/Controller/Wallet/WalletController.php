<?php

namespace Leos\Application\RestBundle\Controller\Wallet;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use Leos\Application\RestBundle\Controller\AbstractController;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class WalletController
 *
 * @package Leos\Application\RestBundle\Controller\Wallet
 *
 * @RouteResource("Wallet", pluralize=false)
 */
class WalletController extends AbstractController
{
    /**
     * @return Wallet
     */
    public function postAction()
    {
       return new Wallet(new WalletId(), new Credit(0), new Credit(0));
    }
}

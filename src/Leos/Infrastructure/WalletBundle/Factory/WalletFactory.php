<?php

namespace Leos\Infrastructure\WalletBundle\Factory;

use Symfony\Component\Form\FormFactory;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\Factory\WalletFactoryInterface;

use Leos\Infrastructure\WalletBundle\Form\WalletType;
use Leos\Infrastructure\Common\Factory\AbstractFactory;

/**
 * Class WalletFactory
 * 
 * @package Leos\Infrastructure\WalletBundle\Factory
 */
class WalletFactory extends AbstractFactory implements WalletFactoryInterface
{
    /**
     * WalletFactory constructor.
     * @param FormFactory $form
     */
    public function __construct(FormFactory $form)
    {
        $this->formClass = WalletType::class;
        parent::__construct($form);
    }

    /**
     * @param array $data
     * @return Wallet
     * @throws \Leos\Infrastructure\Common\Exception\Form\FormException
     */
    public function create(array $data): Wallet
    {
        return $this->execute(self::CREATE, $data);
    }
}

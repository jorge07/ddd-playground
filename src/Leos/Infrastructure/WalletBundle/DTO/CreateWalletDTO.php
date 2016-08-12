<?php

namespace Leos\Infrastructure\WalletBundle\DTO;

/**
 * Class CreateWalletDTO
 *
 * @package Leos\Domain\Wallet\DTO
 */
class CreateWalletDTO
{
    /**
     * @var int
     */
    private $initialAmountReal;

    /**
     * @var int
     */
    private $initialAmountBonus;

    /**
     * CreateWalletDTO constructor.
     *
     * @param int $initialAmountReal
     * @param int $initialAmountBonus
     */
    public function __construct(int $initialAmountReal, int $initialAmountBonus)
    {
        $this->initialAmountReal = $initialAmountReal;
        $this->initialAmountBonus = $initialAmountBonus;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'real'  => [ 'amount' => $this->initialAmountReal ],
            'bonus' => [ 'amount' => $this->initialAmountBonus ]
        ];
    }
}

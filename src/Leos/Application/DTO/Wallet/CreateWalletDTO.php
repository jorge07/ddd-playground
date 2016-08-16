<?php

namespace Leos\Application\DTO\Wallet;

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
     * @var bool
     */
    private $persist;

    /**
     * CreateWalletDTO constructor.
     *
     * @param int $initialAmountReal
     * @param int $initialAmountBonus
     * @param bool $persist
     */
    public function __construct(int $initialAmountReal, int $initialAmountBonus, bool $persist = true)
    {
        $this->initialAmountReal = $initialAmountReal;
        $this->initialAmountBonus = $initialAmountBonus;
        $this->persist = $persist;
    }

    /**
     * @return bool
     */
    public function hasPersistence(): bool
    {
        return $this->persist;
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

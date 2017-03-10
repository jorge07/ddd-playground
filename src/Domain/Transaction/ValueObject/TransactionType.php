<?php

namespace Leos\Domain\Transaction\ValueObject;

use Leos\Domain\Transaction\Exception\InvalidTransactionTypeException;

/**
 * Class TransactionType
 *
 * @package Leos\Domain\Transaction\Model
 */
class TransactionType
{
    const
        CREATE_WALLET = 'create_wallet',
        DEPOSIT = 'deposit',
        WITHDRAWAL = 'withdrawal',
        ROLLBACK_DEPOSIT = 'rollback_deposit',
        ROLLBACK_WITHDRAWAL = 'rollback_withdrawal'
    ;

    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {
        $this->setType($type);
    }

    /**
     * @param string $type
     *
     * @throws InvalidTransactionTypeException
     */
    private function setType(string $type): void
    {
        if (!self::isValid($type)) {

            throw new InvalidTransactionTypeException();
        }

        $this->type = $type;
    }

    public static function types(): array
    {
        return [
            self::CREATE_WALLET,
            self::DEPOSIT,
            self::ROLLBACK_DEPOSIT,
            self::WITHDRAWAL,
            self::ROLLBACK_WITHDRAWAL
        ];
    }

    public function isCredit(): bool
    {
        return in_array($this->type, [
            self::DEPOSIT,
            self::ROLLBACK_WITHDRAWAL
        ]);
    }

    public function isDebit(): bool
    {
        return in_array($this->type, [
            self::ROLLBACK_DEPOSIT,
            self::WITHDRAWAL
        ]);
    }

    public static function isValid(string $type): bool
    {
        return in_array($type, self::types());
    }

    public function __toString(): string
    {
        return (string) $this->type;
    }
}

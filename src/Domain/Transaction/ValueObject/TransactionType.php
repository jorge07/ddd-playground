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

    /**
     * TransactionType constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->setType($type);
    }

    /**
     * @param string $type
     *
     * @throws InvalidTransactionTypeException
     */
    private function setType(string $type)
    {
        if (!self::isValid($type)) {

            throw new InvalidTransactionTypeException();
        }

        $this->type = $type;
    }

    /**
     * @return array
     */
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

    /**
     * @return bool
     */
    public function isCredit(): bool
    {
        return in_array($this->type, [
            self::DEPOSIT,
            self::ROLLBACK_WITHDRAWAL
        ]);
    }

    /**
     * @return bool
     */
    public function isDebit(): bool
    {
        return in_array($this->type, [
            self::ROLLBACK_DEPOSIT,
            self::WITHDRAWAL
        ]);
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::types());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->type;
    }
}

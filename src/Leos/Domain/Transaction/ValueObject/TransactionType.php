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
        DEBIT = 'debit',
        CREDIT = 'credit'
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
            self::CREDIT,
            self::DEBIT
        ];
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

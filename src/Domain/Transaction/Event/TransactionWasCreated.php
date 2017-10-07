<?php

namespace Leos\Domain\Transaction\Event;

use Leos\Domain\Common\Event\AbstractEvent;
use Leos\Domain\Common\ValueObject\AggregateRootId;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;

class TransactionWasCreated extends AbstractEvent
{
    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $walletId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var int
     */
    private $real;

    /**
     * @var int
     */
    private $bonus;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $currency;

    public function __construct(
        AggregateRootId $transactionId,
        string $type,
        WalletId $walletId,
        AggregateRootId $userId,
        int $real,
        int $bonus,
        Currency $currency,
        \DateTime $createdAt
    ) {
        parent::__construct();

        $this->transactionId = $transactionId->__toString();
        $this->type = $type;
        $this->walletId = $walletId->__toString();
        $this->userId = $userId->__toString();
        $this->real = $real;
        $this->bonus = $bonus;
        $this->createdAt = $createdAt;
        $this->currency = $currency->code();
    }
}

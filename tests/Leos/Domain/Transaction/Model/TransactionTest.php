<?php

namespace Leos\Domain\Transaction\Model;

use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class TransactionTest
 *
 * @package Leos\Domain\Transaction\Model
 */
class TransactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $transaction = new Transaction(new TransactionId(), new TransactionType(TransactionType::CREDIT));

        self::assertTrue(null !== $transaction->id());
        self::assertEquals(TransactionType::CREDIT, $transaction->type());
        self::assertNull($transaction->referralTransaction());

        $transaction->setReferralTransaction(new Transaction(new TransactionId(), new TransactionType(TransactionType::CREDIT)));

        self::assertNotNull($transaction->referralTransaction());
    }
}

<?php

namespace Tests\Leos\Domain\Transaction\ValueObject;

use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class TransactionTypeTest
 *
 * @package Tests\Leos\Domain\Transaction\Model
 */
class TransactionTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testTypes()
    {
        self::assertTrue(is_array(TransactionType::types()));
        self::assertTrue(in_array('debit', TransactionType::types()));
        self::assertTrue(in_array('credit', TransactionType::types()));
    }

    /**
     * @group unit
     */
    public function testGetters()
    {
        $type = new TransactionType(TransactionType::DEBIT);

        self::assertEquals(TransactionType::DEBIT, (string) $type);
    }

    /**
     * @group unit
     */
    public function testValidation()
    {
        self::assertFalse(TransactionType::isValid('Nigga'));
    }

    /**
     * @group unit
     */
    public function testConstructValidation()
    {
        try {

            new TransactionType('Nigga');

            self::assertTrue(false);

        } catch (\Exception $e) {

            self::assertTrue(true);
        }
    }

}

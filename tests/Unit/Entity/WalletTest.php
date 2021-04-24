<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use App\Entity\Wallet;
use App\Exceptions\WalletException;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    private Wallet $wallet;

    protected function setUp(): void
    {
        $this->wallet = new Wallet(new User());
    }

    public function testShouldDepositValueAndIncreaseAmount()
    {
        $this->wallet->deposit(100);

        self::assertIsFloat($this->wallet->getAmount());
        self::assertEquals(100, $this->wallet->getAmount());
    }

    public function testShouldNotIncreaseAmountWithNegativeValue()
    {
        $this->wallet->deposit(-50);

        self::assertIsFloat($this->wallet->getAmount());
        self::assertEquals(0, $this->wallet->getAmount());
    }

    public function testShoulWithdrawValueAndDecreaseAmount()
    {
        $this->wallet->deposit(500);
        $this->wallet->withdraw(200);

        self::assertIsFloat($this->wallet->getAmount());
        self::assertEquals(300, $this->wallet->getAmount());
    }

    public function testShouldNotWithdrawIfWalletDoestHaveEnoughMoney()
    {
        self::expectException(WalletException::class);

        $this->wallet->deposit(100);
        $this->wallet->withdraw(200);
    }

    public function testShouldTransferToAnotherWallet()
    {
        $otherWallet = new Wallet(new User, 100);
        $this->wallet->deposit(35);
        $this->wallet->transferTo($otherWallet, 35);

        self::assertEquals(135, $otherWallet->getAmount());
        self::assertEquals(0, $this->wallet->getAmount());
    }
}
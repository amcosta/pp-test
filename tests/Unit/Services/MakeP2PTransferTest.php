<?php

namespace App\Tests\Unit\Services;

use App\Entity\P2PTransaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Services\Authorization;
use App\Services\MakeP2PTransfer;
use Doctrine\ORM\EntityManagerInterface;
use \Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MakeP2PTransferTest extends TestCase
{
    private function buildUserAndWallet(float $amount): array
    {
        $user = m::mock(User::class);
        $wallet = new Wallet($user, $amount);
        $user->expects('getWallet')->withNoArgs()->andReturn($wallet);

        return [$user, $wallet];
    }

    public function testShouldMakeP2PTransfer()
    {
        [$payee, $payeeWallet] = $this->buildUserAndWallet(100);
        [$payer, $payerWallet] = $this->buildUserAndWallet(100);

        $transaction = m::mock(P2PTransaction::class);
        $transaction->expects('getPayee')->withNoArgs()->andReturn($payee);
        $transaction->expects('getPayer')->withNoArgs()->andReturn($payer);
        $transaction->expects('getAmount')->withNoArgs()->andReturn(50);

        $service = new MakeP2PTransfer(
            m::spy(EntityManagerInterface::class),
            m::spy(Authorization::class),
            m::spy(EventDispatcher::class)
        );
        $service->execute($transaction);

        self::assertEquals(50, $payerWallet->getAmount());
        self::assertEquals(150, $payeeWallet->getAmount());
    }
}

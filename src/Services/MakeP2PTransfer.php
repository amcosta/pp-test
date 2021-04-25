<?php

namespace App\Services;

use App\Entity\P2PTransaction;
use App\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;

class MakeP2PTransfer
{
    private EntityManagerInterface $entityManager;
    private Authorization $authorization;

    public function __construct(EntityManagerInterface $entityManager, Authorization $authorization)
    {
        $this->entityManager = $entityManager;
        $this->authorization = $authorization;
    }

    public function execute(P2PTransaction $transaction)
    {
        $payee = $transaction->getPayee();
        $payer = $transaction->getPayer();

        $this->authorization->checkUser($payer);
        $this->movementMoney($transaction->getAmount(), $payer->getWallet(), $payee->getWallet());

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();
    }

    private function movementMoney(float $amount, Wallet $payerWallet, Wallet $payeeWallet): void
    {
        $payerWallet->transferTo($payeeWallet, $amount);

        $this->entityManager->persist($payerWallet);
        $this->entityManager->persist($payeeWallet);
    }
}
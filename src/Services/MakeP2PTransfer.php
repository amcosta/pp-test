<?php

namespace App\Services;

use App\Entity\P2PTransaction;
use App\Entity\Wallet;
use App\Events\P2PTransactionCreated;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MakeP2PTransfer
{
    private EntityManagerInterface $entityManager;
    private Authorization $authorization;
    private EventDispatcher $dispatcher;

    public function __construct(EntityManagerInterface $entityManager,
                                Authorization $authorization,
                                EventDispatcher $dispatcher)
    {
        $this->entityManager = $entityManager;
        $this->authorization = $authorization;
        $this->dispatcher = $dispatcher;
    }

    public function execute(P2PTransaction $transaction)
    {
        $payee = $transaction->getPayee();
        $payer = $transaction->getPayer();

        $this->authorization->checkUser($payer);
        $this->movementMoney($transaction->getAmount(), $payer->getWallet(), $payee->getWallet());

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new P2PTransactionCreated($transaction), P2PTransactionCreated::EVENT_NAME);
    }

    private function movementMoney(float $amount, Wallet $payerWallet, Wallet $payeeWallet): void
    {
        $payerWallet->transferTo($payeeWallet, $amount);

        $this->entityManager->persist($payerWallet);
        $this->entityManager->persist($payeeWallet);
    }
}
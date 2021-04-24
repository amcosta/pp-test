<?php

namespace App\Services;

use App\DTO\MakeP2PTransferRequest;
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

    public function execute(MakeP2PTransferRequest $request)
    {
        $payee = $request->getPayee();
        $payer = $request->getPayer();

        $this->authorization->checkUser($payer);
        $this->updateWallets($request->getAmount(), $payer->getWallet(), $payee->getWallet());
    }

    private function updateWallets(float $amount, Wallet $payerWallet, Wallet $payeeWallet): void
    {
        $payerWallet->withdraw($amount);
        $payeeWallet->deposit($amount);

        $this->entityManager->persist($payerWallet);
        $this->entityManager->persist($payeeWallet);
        $this->entityManager->flush();
    }
}
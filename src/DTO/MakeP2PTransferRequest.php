<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class MakeP2PTransferRequest
{
    private User $payee;
    private float $amount;
    private User $payer;

    public function __construct(Security $security)
    {
        $this->payer = $security->getUser();
    }

    public function getPayee(): User
    {
        return $this->payee;
    }

    public function setPayee(User $payee): void
    {
        $this->payee = $payee;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getPayer(): User
    {
        return $this->payer;
    }
}

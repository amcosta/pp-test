<?php

namespace App\DTO;

use App\Entity\User;

class MakeP2PTransferRequest
{
    private User $payee;
    private float $amount;

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
}

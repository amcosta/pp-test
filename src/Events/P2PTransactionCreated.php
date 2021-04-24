<?php declare(strict_types=1);

namespace App\Events;

use App\Entity\P2PTransaction;

class P2PTransactionCreated
{
    public const EVENT_NAME = 'p2p-transaction.created';

    private P2PTransaction $transaction;

    public function __construct(P2PTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getTransaction(): P2PTransaction
    {
        return $this->transaction;
    }
}

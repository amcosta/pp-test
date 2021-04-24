<?php

namespace App\Entity;

use App\Exceptions\WalletException;
use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $amount;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="wallet")
     */
    private User $user;

    public function __construct(User $user, float $amount = 0)
    {
        $this->user = $user;
        $this->amount = $amount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function deposit(float $value): void
    {
        if ($value > 0) {
            $this->amount += $value;
        }
    }

    public function withdraw(float $value): void
    {
        if ($this->amount < $value) {
            throw new WalletException('Wallet does\'t have have enough money');
        }

        $this->amount -= $value;
    }

    public function transferTo(Wallet $wallet, float $amount): void
    {
        $this->withdraw($amount);
        $wallet->deposit($amount);
    }
}

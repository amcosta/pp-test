<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\P2PTransactionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=P2PTransactionRepository::class)
 * @ORM\Table(name="p2p_transaction")
 */
class P2PTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private User $payer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private User $payee;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $amount;

    private DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayer(): User
    {
        return $this->payer;
    }

    public function setPayer(User $payer): self
    {
        $this->payer = $payer;
        return $this;
    }

    public function getPayee(): ?User
    {
        return $this->payee;
    }

    public function setPayee(User $payee): self
    {
        $this->payee = $payee;
        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
}

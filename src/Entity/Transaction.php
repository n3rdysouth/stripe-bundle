<?php

namespace NerdySouth\StripeBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'stripe_transaction')]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $stripeSessionId;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $subscriptionId = null; // For recurring transactions

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $isSubscription = false;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $amount; // Amount in the smallest unit (cents)

    #[ORM\Column(type: Types::STRING, length: 3, nullable: false)]
    private string $currency;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: false)]
    private string $status; // E.g., "pending", "paid", "active", "canceled"

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStripeSessionId(): string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;
        return $this;
    }

    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    public function setSubscriptionId(?string $subscriptionId): self
    {
        $this->subscriptionId = $subscriptionId;
        return $this;
    }

    public function getIsSubscription(): bool
    {
        return $this->isSubscription;
    }

    public function setIsSubscription(bool $isSubscription): self
    {
        $this->isSubscription = $isSubscription;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
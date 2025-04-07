<?php

namespace NerdySouth\StripeBundle\Service;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use NerdySouth\StripeBundle\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    private string $stripeSecretKey;

    public function __construct(
        string $stripeSecretKey,
        protected EntityManagerInterface $entityManager
    ) {
        $this->stripeSecretKey = $stripeSecretKey;
        Stripe::setApiKey($this->stripeSecretKey);
    }

    public function createPaymentUrl(
        float $amount,
        string $currency,
        string $successUrl,
        string $cancelUrl,
        bool $isRecurring,
        ?string $productName = null,
        ?string $productDescription = null
    ): string {
        // Convert amount to cents (required by Stripe)
        $amountInCents = $amount * 100;

        // Create a transaction in the database and save it
        $transaction = new Transaction();
        $transaction->setAmount($amountInCents);
        $transaction->setCurrency($currency);
        $transaction->setIsSubscription($isRecurring);
        $transaction->setStatus('pending');
        $transaction->setCreatedAt(new \DateTime());

        // Create Stripe payment or subscription session
        $sessionData = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => $isRecurring ? ($productName ?? 'Subscription Plan') : ($productName ?? 'One-Time Payment'),
                        'description' => $productDescription
                    ],
                    'unit_amount' => $amountInCents,
                    'recurring' => $isRecurring ? [
                        'interval' => 'month', // Can be customized
                    ] : null,
                ],
                'quantity' => 1,
            ]],
            'mode' => $isRecurring ? 'subscription' : 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ];

        $session = Session::create($sessionData);

        // Update transaction with the Stripe session ID
        $transaction->setStripeSessionId($session->id);
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $session->url;
    }
}
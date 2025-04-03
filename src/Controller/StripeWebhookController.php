<?php

namespace NerdySouth\StripeBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Stripe\Exception\SignatureVerificationException;
use NerdySouth\StripeBundle\Event\StripeEvent;
use NerdySouth\StripeBundle\Entity\Transaction;
use Stripe\Webhook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class StripeWebhookController
{
    private string $stripeWebhookSecret;

    public function __construct(
        string $stripeWebhookSecret,
        protected EventDispatcherInterface $dispatcher,
        protected EntityManagerInterface $entityManager
    ) {
        $this->stripeWebhookSecret = $stripeWebhookSecret;
    }

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->headers->get('stripe-signature');

        if (!$sigHeader) {
            throw new BadRequestHttpException('Missing Stripe signature header.');
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $this->stripeWebhookSecret);

            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->handleCheckoutSessionCompleted($event);
                    break;

                case 'invoice.payment_succeeded':
                    $this->handleInvoicePaymentSucceeded($event);
                    break;

                case 'customer.subscription.created':
                    $this->handleSubscriptionCreated($event);
                    break;

                case 'customer.subscription.updated':
                    $this->handleSubscriptionUpdated($event);
                    break;

                case 'customer.subscription.deleted':
                    $this->handleSubscriptionDeleted($event);
                    break;

                default:
                    // todo: Log unsupported events
                    break;
            }

            $stripeEvent = new StripeEvent($event);
            $this->dispatcher->dispatch($stripeEvent, $event->type);

            return new JsonResponse(['success' => true], 200);
        } catch (\UnexpectedValueException $e) {
            return new JsonResponse(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return new JsonResponse(['error' => 'Invalid signature'], 400);
        }
    }

    private function handleCheckoutSessionCompleted($event): void
    {
        $sessionId = $event->data->object->id;

        $transaction = $this->entityManager
            ->getRepository(Transaction::class)
            ->findOneBy(['stripeSessionId' => $sessionId]);

        if ($transaction) {
            $transaction->setStatus('paid');
            $this->entityManager->flush();
        }
    }

    private function handleInvoicePaymentSucceeded($event): void
    {
        $subscriptionId = $event->data->object->subscription ?? null;

        if ($subscriptionId) {
            $transaction = $this->entityManager
                ->getRepository(Transaction::class)
                ->findOneBy(['subscriptionId' => $subscriptionId]);

            if ($transaction) {
                $transaction->setStatus('active');
                $this->entityManager->flush();
            }
        }
    }

    private function handleSubscriptionCreated($event): void
    {
        $subscriptionId = $event->data->object->id;

        $transaction = new Transaction();
        $transaction->setSubscriptionId($subscriptionId);
        $transaction->setIsSubscription(true);
        $transaction->setStatus('active');
        $transaction->setAmount(0); // Subscriptions typically track individual invoices for amounts
        $transaction->setCurrency('usd'); // Set a default base currency or extract if available

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();
    }

    private function handleSubscriptionUpdated($event): void
    {
        $subscriptionId = $event->data->object->id;
        $status = $event->data->object->status; // E.g., "active", "canceled", etc.

        $transaction = $this->entityManager
            ->getRepository(Transaction::class)
            ->findOneBy(['subscriptionId' => $subscriptionId]);

        if ($transaction) {
            $transaction->setStatus($status);
            $this->entityManager->flush();
        }
    }

    private function handleSubscriptionDeleted($event): void
    {
        $subscriptionId = $event->data->object->id;

        $transaction = $this->entityManager
            ->getRepository(Transaction::class)
            ->findOneBy(['subscriptionId' => $subscriptionId]);

        if ($transaction) {
            $transaction->setStatus('canceled');
            $this->entityManager->flush();
        }
    }
}
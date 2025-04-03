<?php

namespace NerdySouth\StripeBundle\EventSubscriber;

use NerdySouth\StripeBundle\Event\StripeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StripeEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'payment_intent.succeeded' => 'onPaymentIntentSucceeded',
            'customer.subscription.created' => 'onSubscriptionCreated',
        ];
    }

    public function onPaymentIntentSucceeded(StripeEvent $event): void
    {
        $stripeEventData = $event->getEventData();
        // Handle successful payment intent logic here
    }

    public function onSubscriptionCreated(StripeEvent $event): void
    {
        $stripeEventData = $event->getEventData();
        // Handle subscription creation logic here
    }
}
<?php

namespace NerdySouth\StripeBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Stripe\Event as StripeEventSdk;

class StripeEvent extends Event
{
    private StripeEventSdk $stripeEvent;

    public function __construct(StripeEventSdk $stripeEvent)
    {
        $this->stripeEvent = $stripeEvent;
    }

    public function getStripeEvent(): StripeEventSdk
    {
        return $this->stripeEvent;
    }

    public function getEventType(): string
    {
        return $this->stripeEvent->type;
    }

    public function getEventData(): array
    {
        return $this->stripeEvent->data->object->toArray();
    }
}
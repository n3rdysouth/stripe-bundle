<?php

namespace NerdySouth\StripeBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Stripe\Event as StripeEventSdk;

class StripeEvent extends Event
{
    // Stripe Event Types
    public const ACCOUNT_UPDATED = 'account.updated';
    public const ACCOUNT_APPLICATION_AUTHORIZED = 'account.application.authorized';
    public const ACCOUNT_APPLICATION_DEAUTHORIZED = 'account.application.deauthorized';
    public const ACCOUNT_EXTERNAL_ACCOUNT_CREATED = 'account.external_account.created';
    public const ACCOUNT_EXTERNAL_ACCOUNT_DELETED = 'account.external_account.deleted';
    public const ACCOUNT_EXTERNAL_ACCOUNT_UPDATED = 'account.external_account.updated';

    public const APPLICATION_FEE_CREATED = 'application_fee.created';
    public const APPLICATION_FEE_REFUNDED = 'application_fee.refunded';

    public const BALANCE_AVAILABLE = 'balance.available';

    public const BILLING_PORTAL_CONFIGURATION_UPDATED = 'billing_portal.configuration.updated';

    public const CAPABILITY_UPDATED = 'capability.updated';

    public const CHARGE_CAPTURED = 'charge.captured';
    public const CHARGE_EXPIRED = 'charge.expired';
    public const CHARGE_FAILED = 'charge.failed';
    public const CHARGE_PENDING = 'charge.pending';
    public const CHARGE_REFUNDED = 'charge.refunded';
    public const CHARGE_SUCCEEDED = 'charge.succeeded';
    public const CHARGE_UPDATED = 'charge.updated';
    public const CHARGE_DISPUTE_CLOSED = 'charge.dispute.closed';
    public const CHARGE_DISPUTE_CREATED = 'charge.dispute.created';
    public const CHARGE_DISPUTE_FUNDS_REINSTATED = 'charge.dispute.funds_reinstated';
    public const CHARGE_DISPUTE_FUNDS_WITHDRAWN = 'charge.dispute.funds_withdrawn';
    public const CHARGE_DISPUTE_UPDATED = 'charge.dispute.updated';

    public const CHECKOUT_SESSION_ASYNC_PAYMENT_FAILED = 'checkout.session.async_payment_failed';
    public const CHECKOUT_SESSION_ASYNC_PAYMENT_SUCCEEDED = 'checkout.session.async_payment_succeeded';
    public const CHECKOUT_SESSION_COMPLETED = 'checkout.session.completed';
    public const CHECKOUT_SESSION_EXPIRED = 'checkout.session.expired';

    public const COUPON_CREATED = 'coupon.created';
    public const COUPON_DELETED = 'coupon.deleted';
    public const COUPON_UPDATED = 'coupon.updated';

    public const CUSTOMER_CREATED = 'customer.created';
    public const CUSTOMER_DELETED = 'customer.deleted';
    public const CUSTOMER_UPDATED = 'customer.updated';
    public const CUSTOMER_SOURCE_CREATED = 'customer.source.created';
    public const CUSTOMER_SOURCE_DELETED = 'customer.source.deleted';
    public const CUSTOMER_SOURCE_EXPIRING = 'customer.source.expiring';
    public const CUSTOMER_SOURCE_UPDATED = 'customer.source.updated';
    public const CUSTOMER_SUBSCRIPTION_CREATED = 'customer.subscription.created';
    public const CUSTOMER_SUBSCRIPTION_DELETED = 'customer.subscription.deleted';
    public const CUSTOMER_SUBSCRIPTION_PAUSED = 'customer.subscription.paused';
    public const CUSTOMER_SUBSCRIPTION_RESUMED = 'customer.subscription.resumed';
    public const CUSTOMER_SUBSCRIPTION_TRIAL_WILL_END = 'customer.subscription.trial_will_end';
    public const CUSTOMER_SUBSCRIPTION_UPDATED = 'customer.subscription.updated';

    public const INVOICE_CREATED = 'invoice.created';
    public const INVOICE_DELETED = 'invoice.deleted';
    public const INVOICE_FINALIZED = 'invoice.finalized';
    public const INVOICE_MARKED_UNCOLLECTIBLE = 'invoice.marked_uncollectible';
    public const INVOICE_PAID = 'invoice.paid';
    public const INVOICE_PAYMENT_ACTION_REQUIRED = 'invoice.payment_action_required';
    public const INVOICE_PAYMENT_FAILED = 'invoice.payment_failed';
    public const INVOICE_PAYMENT_SUCCEEDED = 'invoice.payment_succeeded';
    public const INVOICE_SENT = 'invoice.sent';
    public const INVOICE_UPCOMING = 'invoice.upcoming';
    public const INVOICE_UPDATED = 'invoice.updated';
    public const INVOICE_VOIDED = 'invoice.voided';

    public const PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED = 'payment_intent.amount_capturable_updated';
    public const PAYMENT_INTENT_CANCELLED = 'payment_intent.canceled';
    public const PAYMENT_INTENT_CREATED = 'payment_intent.created';
    public const PAYMENT_INTENT_PARTIALLY_FUNDED = 'payment_intent.partially_funded';
    public const PAYMENT_INTENT_PAYMENT_FAILED = 'payment_intent.payment_failed';
    public const PAYMENT_INTENT_PROCESSING = 'payment_intent.processing';
    public const PAYMENT_INTENT_REQUIRES_ACTION = 'payment_intent.requires_action';
    public const PAYMENT_INTENT_SUCCEEDED = 'payment_intent.succeeded';

    public const PAYMENT_METHOD_ATTACHED = 'payment_method.attached';
    public const PAYMENT_METHOD_AUTOMATICALLY_UPDATED = 'payment_method.automatically_updated';
    public const PAYMENT_METHOD_DETACHED = 'payment_method.detached';
    public const PAYMENT_METHOD_UPDATED = 'payment_method.updated';

    public const PAYOUT_CANCELED = 'payout.canceled';
    public const PAYOUT_CREATED = 'payout.created';
    public const PAYOUT_FAILED = 'payout.failed';
    public const PAYOUT_PAID = 'payout.paid';
    public const PAYOUT_UPDATED = 'payout.updated';

    public const PLAN_CREATED = 'plan.created';
    public const PLAN_DELETED = 'plan.deleted';
    public const PLAN_UPDATED = 'plan.updated';

    public const PRODUCT_CREATED = 'product.created';
    public const PRODUCT_DELETED = 'product.deleted';
    public const PRODUCT_UPDATED = 'product.updated';

    public const REFUND_CREATED = 'refund.created';
    public const REFUND_UPDATED = 'refund.updated';

    public const REVIEW_CLOSED = 'review.closed';
    public const REVIEW_OPENED = 'review.opened';

    public const SUBSCRIPTION_SCHEDULE_ABORTED = 'subscription_schedule.aborted';
    public const SUBSCRIPTION_SCHEDULE_CANCELED = 'subscription_schedule.canceled';
    public const SUBSCRIPTION_SCHEDULE_COMPLETED = 'subscription_schedule.completed';
    public const SUBSCRIPTION_SCHEDULE_CREATED = 'subscription_schedule.created';
    public const SUBSCRIPTION_SCHEDULE_EXPIRING = 'subscription_schedule.expiring';
    public const SUBSCRIPTION_SCHEDULE_RELEASED = 'subscription_schedule.released';
    public const SUBSCRIPTION_SCHEDULE_UPDATED = 'subscription_schedule.updated';

    public const TAX_RATE_CREATED = 'tax_rate.created';
    public const TAX_RATE_UPDATED = 'tax_rate.updated';

    public const TOPUP_CANCELED = 'topup.canceled';
    public const TOPUP_CREATED = 'topup.created';
    public const TOPUP_FAILED = 'topup.failed';
    public const TOPUP_SUCCEEDED = 'topup.succeeded';

    public const TRANSFER_CREATED = 'transfer.created';
    public const TRANSFER_FAILED = 'transfer.failed';
    public const TRANSFER_PAID = 'transfer.paid';
    public const TRANSFER_UPDATED = 'transfer.updated';
    public const TRANSFER_REVERSED = 'transfer.reversed';

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
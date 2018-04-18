<?php


namespace App\Services\Payment;


class PaymentResultEnum
{
    public const PAYMENT_NOT_NEEDED = 0;
    public const PAYMENT_SUCCESS_FROM_BALANCE = 1;
    public const PAYMENT_REQUIRED_MANUALLY = 2;
}
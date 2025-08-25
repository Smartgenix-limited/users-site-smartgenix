<?php

namespace App\Enums;

abstract class PaymentStatus
{
    const UnPaid         = 'unpaid';
    const Paid           = 'paid';
    const Pending        = 'pending';
}

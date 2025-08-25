<?php

namespace App\Enums;

abstract class SupportStatus
{
    const UnAnswered   = 'unanswered';
    const Answered     = 'answered';
    const Resolved     = 'resolved';
    const Closed       = 'closed';
}

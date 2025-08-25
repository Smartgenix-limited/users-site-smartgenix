<?php

namespace App\Enums;

abstract class JobStatus
{
    const Pending           = 'pending';
    const Started           = 'started';
    const Paused            = 'paused';
    const Completed         = 'completed';
}

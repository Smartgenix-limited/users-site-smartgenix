<?php

namespace App\Enums;

abstract class UserType
{
    const Admin        = 'admin';
    const Staff        = 'staff';
    const Recovery     = 'recovery';
    const Solo         = 'solo';
    const Trader       =  'trader';
    const Enterprise   =  'enterprise';
}

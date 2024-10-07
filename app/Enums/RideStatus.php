<?php

namespace App\Enums; 

enum RideStatus: string
{
    case REQUESTED = 'REQUESTED';
    case CANCELED = 'CANCELED';
}
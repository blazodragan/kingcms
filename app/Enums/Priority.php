<?php

namespace App\Enums;

enum Priority: string

{
    case LOW = 'P1';
    case NORMAL = 'P2';
    case HIGH = 'P3';
}
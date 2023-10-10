<?php

namespace App\Enums;

enum Status: string

{
    case DRAFT = 'Draft';
    case PUBLISHED = 'Published';
    case REVIEW = 'Review';
    
    
}
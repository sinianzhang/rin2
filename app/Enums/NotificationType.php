<?php

namespace App\Enums;

enum NotificationType: string
{
    case Marketing = 'marketing';
    case Invoices = 'invoices';
    case System = 'system';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}

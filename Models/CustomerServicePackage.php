<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerServicePackage extends Pivot
{
    protected $casts = [
        'start' => 'date',
        'end' => 'date'
    ];
}

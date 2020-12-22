<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }
}

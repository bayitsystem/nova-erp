<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class InvoiceStatus extends Model
{
    const DRAFT = 1;

    const PENDING = 2;

    const PARTIAL = 3;

    const PAID = 4;

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_status_id');
    }
}

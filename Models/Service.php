<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function typeOfService()
    {
        return $this->belongsTo(TypeOfService::class);
    }

    public function ServicePackages()
    {
        return $this->belongsToMany(ServicePackage::class)
            ->withPivot('price');
    }

    public function invoiceItems(){
        return $this->morphMany(InvoiceItem::class, 'invoice_itemable');
    }
}

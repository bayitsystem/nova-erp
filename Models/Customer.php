<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $appends = ['name'];

    public function ServicePackages()
    {
        return $this->belongsToMany(ServicePackage::class)
            ->using(CustomerServicePackage::class)
            ->withPivot(
                'start',
                'end',
                'payday',
                'payday_limit',
                'is_activate'
            );
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getClientStatus()
    {
        return true;
    }

    public function getIsHasOverdueInvoicesAttribute()
    {
        return ($this->overDueInvoices()->count()) ? true : false;
    }

    public function getIsSolventAttribute()
    {
        return ! $this->isHasOverdueInvoices;
    }

    public function getTotalOverdueInvoicesAttribute()
    {
        return $this->overDueInvoices()
            ->sum('total');
    }

    public function overDueInvoices()
    {
        return $this->invoices
            ->where('invoice_status_id', InvoiceStatus::PENDING);
    }
}

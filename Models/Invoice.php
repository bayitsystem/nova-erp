<?php

namespace NovaModules\Erp\Models;

use Akaunting\Money\Money;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payday' => 'date',
        'payday_limit' => 'date'
    ];

    protected $appends = ['balance_due', 'total_paid', 'invoice_type_id'];

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'invoiceable_id');
    }

    public function provider() {
        return $this->belongsTo(Provider::class, 'invoiceable_id');
    }

    public function  invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class)
            ->with('invoiceItemable');
    }

    public function invoice_status()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    /*
     * Attributes
     */

    public function getTotalPaidAttribute()
    {
        return bcadd( $this->vouchers->sum('total'), 0 , 2);
    }

    public function getBalanceDueAttribute()
    {
        return bcadd($this->total - $this->total_paid, 0, 2);
    }


    public function getInvoiceTypeIdAttribute()
    {
        switch ($this->invoiceable_type) {
            case Customer::class:
                return 'CLIENT';
                break;
            case Provider::class:
                return 'PROVIDER';
            default:
                return '-';
                break;
        }

    }
    /*
     * States
     * */
    public function isEditable()
    {
        return false;
    }

    public function isDraft()
    {
        return $this->invoice_status_id == InvoiceStatus::DRAFT ? true : false;
    }

    public function isPending()
    {
        return $this->invoice_status_id == InvoiceStatus::PENDING ? true : false;
    }

    public function isPartial()
    {
        return $this->invoice_status_id == InvoiceStatus::PARTIAL ? true : false;
    }

    public function isPaid()
    {
        return $this->invoice_status_id == InvoiceStatus::PAID ? true : false;
    }

    public function toDraft()
    {
        $this->update(['invoice_status_id' => InvoiceStatus::DRAFT]);
        return $this;
    }

    public function toPending()
    {
        $this->update(['invoice_status_id' => InvoiceStatus::PENDING]);
        return $this;
    }

    public function toPartial()
    {
        $this->update(['invoice_status_id' => InvoiceStatus::PARTIAL]);
        return $this;
    }

    public function toPaid()
    {
        $this->update(['invoice_status_id' => InvoiceStatus::PAID]);
        return $this;
    }
}

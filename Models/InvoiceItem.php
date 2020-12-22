<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $casts = [
        'price' => 'decimal:2',
        'total_cost' => 'decimal:2'
    ];

    public $fillable = [
        'invoice_id',
        'invoice_itemable_type',
        'invoice_itemable_id',
        'cuantity',
        'price',
        'total_cost'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->updateTotalInvoice();
        });

        static::deleted(function ($model) {
            $model->updateTotalInvoice();
        });
    }

    private function updateTotalInvoice()
    {
        $total = 0;
        foreach ($this->invoice->invoiceItems as $item){
            $total  += $item->total_cost;
        }

        $this->invoice->total = $total;
        $this->invoice->update();
    }

    public function invoice (){
        return $this->belongsTo(Invoice::class);
    }

    public function invoiceItemable()
    {
        return $this->morphTo();
    }
}

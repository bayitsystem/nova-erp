<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $fillable = [
        'invoice_id',
        'referense',
        'commets',
        'total',
        'banck_account_id',
        'payment_method_id',
        'operationed_at',
    ];

    protected $with = ['banckAccount'];

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $invoice = $model->invoice;
            $totalVoucher = $invoice->vouchers->sum('total');

            if($totalVoucher <  $invoice->total){
                $model->invoice->invoice_status_id = InvoiceStatus::PARTIAL;
                $model->invoice->update();
                return;
            }

            $model->invoice->invoice_status_id = InvoiceStatus::PAID;
            $model->invoice->payment_date = now();
            $model->invoice->update();
        });

        static::deleted(function ($model) {
            $invoice = $model->invoice;
            $totalVoucher = $invoice->vouchers->sum('total');

            if($totalVoucher == 0) {
                $model->invoice->invoice_status_id = InvoiceStatus::PENDING;
                $model->invoice->payment_date = null;
                $model->invoice->update();
                return;
            }

            if($totalVoucher <  $invoice->total){
                $model->invoice->invoice_status_id = InvoiceStatus::PARTIAL;
                $model->invoice->payment_date = null;
                $model->invoice->update();
                return;
            }
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function banckAccount()
    {
        return $this->belongsTo(BanckAccount::class);
    }
}

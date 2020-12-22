<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'description'];

    const CASH = 1;
    const BANCK_DEPOSIT = 2;
    const BANCK_TRANSFER = 3;
    const CREDIT_CARD = 4;
    const CHECK = 5;

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}

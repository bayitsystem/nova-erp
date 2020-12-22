<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class BanckAccount extends Model
{
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}

<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}

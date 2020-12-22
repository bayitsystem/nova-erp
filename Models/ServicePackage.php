<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot('price');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class)
            ->using(CustomerServicePackage::class)
            ->withPivot(
                'start',
                'end',
                'payday',
                'payday_limit',
                'is_activate'
            );
    }
}

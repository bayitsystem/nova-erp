<?php

namespace NovaModules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOfService extends Model
{
    const CLIENTS = 1;

    const PROVIDERS = 2;

    public function services ()
    {
        return $this->hasMany(Service::class);
    }
}

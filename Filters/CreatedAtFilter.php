<?php

namespace NovaModules\Erp\Filters;

use Ampeco\Filters\DateRangeFilter;
use App\Nova\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CreatedAtFilter extends DateRangeFilter
{
    public $name = 'Fecha de creacion';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $from = Carbon::parse($value[0]);
        $to = Carbon::parse($value[1]);

        return $query->whereBetween('created_at', [$from, $to]);
    }
}

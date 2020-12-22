<?php

namespace NovaModules\Erp\Filters;

use NovaModules\Erp\Models\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class OverdueInvoiceFilter extends BooleanFilter
{
    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Facturas Vencidas';

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
        if ($value['overDue']) {
            return $query->whereNotIn('invoice_status_id', [InvoiceStatus::DRAFT, InvoiceStatus::PAID])
                ->where('payday_limit', '<', Carbon::now());
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Facturas vencidas' => 'overDue'
        ];
    }
}

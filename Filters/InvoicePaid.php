<?php

namespace NovaModules\Erp\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class InvoicePaid extends Filter
{
    public $name = 'Estado';
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

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
        return $query->where('invoice_status_id', $value);
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
            'Borrador' => 1,
            'Pendientes' => 2,
            'Pago Parcial' => 3,
            'Pagadas' => 4
        ];
    }
}

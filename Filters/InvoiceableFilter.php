<?php

namespace NovaModules\Erp\Filters;

use NovaModules\Erp\Models\Customer;
use App\Provider;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class InvoiceableFilter extends BooleanFilter
{
    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Tipo de facturas';

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
        if ($value['clients'] and $value['providers']) {
            return $query;
        }

        if ($value['clients']) {
            return $this->clientInvoices($query);
        }

        if ($value['providers']) {
            return $this->providerInvoices($query);
        }

        return $query;
    }

    private function clientInvoices ($query)
    {
        return $query->where('invoiceable_type', Customer::class);
    }

    private function providerInvoices ($query)
    {
        return $query->where('invoiceable_type', Provider::class);

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
            'Clientes' => 'clients',
            'Proveedores' => 'providers'
        ];
    }
}

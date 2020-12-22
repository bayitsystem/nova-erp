<?php

namespace NovaModules\Erp\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;
use NovaModules\Erp\Models\Invoice;
use NovaModules\Erp\Models\InvoiceStatus;

class BillingBalance extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        //return $this->sum($request, Invoice::with('invoice_status'), 'total', 'invoice_status.id');

        $statuses = InvoiceStatus::with('invoices')
            ->where('id', '<>', 1)
            ->get();

        return $this->result(
            $statuses->flatMap(function ($status) {
                return [
                    $status->name => $status->invoices->sum('total')
                ];
            })->toArray()
        );
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'billing-balance';
    }
}

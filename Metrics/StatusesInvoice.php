<?php

namespace NovaModules\Erp\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;
use NovaModules\Erp\Models\InvoiceStatus;

class StatusesInvoice extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $statuses = InvoiceStatus::withCount('invoices')->get();

        return $this->result(
            $statuses->flatMap(function ($status) {
                return [
                    $status->name => $status->invoices_count
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
        return 'statuses-invoice';
    }
}

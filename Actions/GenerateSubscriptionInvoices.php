<?php

namespace NovaModules\Erp\Actions;

use NovaModules\Erp\Models\Invoice;
use NovaModules\Erp\Models\InvoiceStatus;
use NovaModules\Erp\Models\Service;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class GenerateSubscriptionInvoices extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Generar Facturas';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $package) {
            $this->genereteInvoicesToUser($package);
        }
    }

    private function genereteInvoicesToUser($package)
    {
        foreach ($package->clients as $client) {
            $invoice = $client->invoices()->create([
                'payday' => ( new Carbon() )->setDay($client->pivot->payday),
                'payday_limit' => ( new Carbon() )->setDay($client->pivot->payday_limit),
                'invoice_status_id' => InvoiceStatus::PENDING
            ]);

            $this->addItemsToInvoice($package->services, $invoice);
        }
    }

    private function addItemsToInvoice($services, $invoice)
    {
        foreach ($services as $service) {
            $invoice->invoiceItems()->create([
                'invoice_itemable_type' => Service::class,
                'invoice_itemable_id' => $service->id,
                'price' => $service->pivot->price,
                'cuantity' => 1,
                'total_cost' => $service->pivot->price
            ]);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}

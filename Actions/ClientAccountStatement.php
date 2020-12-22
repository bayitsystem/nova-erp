<?php

namespace NovaModules\Erp\Actions;

use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ClientAccountStatement extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Generar Estado de cuenta';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $pdf = \PDF::loadView('pdf.clientAccountStatement', compact('models'));
        $pdf->setPaper('a4')->save('storage/download.pdf');
        return Action::download('/storage/download.pdf', 'download.pdf');
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

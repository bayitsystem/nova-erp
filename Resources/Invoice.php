<?php

namespace NovaModules\Erp\Resources;

use NovaModules\Erp\Actions\SendInvoiceByEmail;
use NovaModules\Erp\Filters\CreatedAtFilter;
use NovaModules\Erp\Filters\InvoiceableFilter;
use NovaModules\Erp\Filters\InvoicePaid;
use NovaModules\Erp\Filters\OverdueInvoiceFilter;
use NovaModules\Erp\Lenses\AllCustomers;
use NovaModules\Erp\Metrics\BillingBalance;
use NovaModules\Erp\Metrics\BillsPaid;
use NovaModules\Erp\Metrics\StatusesInvoice;
use Bayit\InvoiceServices\InvoiceServices;
use Bayit\InvoiceVaucher\InvoiceVaucher;
use Bayit\InvoiceVaucher\ToolServiceProvider;
use Bayit\Locked\Locked;
use Bayit\ResumenInvoice\ResumenInvoice;
use Laravel\Nova\Fields\MorphTo;
use function foo\func;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Invoice extends Resource
{
    public static $category = 'ERP';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'NovaModules\Erp\Models\Invoice';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['customer'];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'client'
    ];

    /*
     *  get the display name
     *  @return string
     */
    public static function label() {
        return 'Facturas';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            MorphTo::make('Invoiceable')->types([
                Customer::class,
                Provider::class
            ])->searchable(),

            Date::make('Created At')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Date::make('Payday')
                ->rules('required', 'date')
                ->hideWhenUpdating(function (){;
                    return !$this->isEditable();
                }),

            Date::make('Payday Limit')
                ->rules('required', 'date', 'after_or_equal:payday')
                ->hideWhenUpdating(function (){;
                    return !$this->isEditable();
                }),

            BelongsTo::make('Invoice Status')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Total')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Total Paid')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Balance Due')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            InvoiceServices::make()
                ->invoice($this),

            InvoiceVaucher::make()
                ->invoice($this),

            ResumenInvoice::make()
                ->invoice($this)
            ->canSee(function () {
                return $this->isPending() || $this->isPaid();
            }),

            Locked::make()
                ->invoice($this),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new BillsPaid(),
            new StatusesInvoice(),
            new BillingBalance()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new InvoiceableFilter(),
            new InvoicePaid(),
            new CreatedAtFilter(),
            new OverdueInvoiceFilter(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new AllCustomers(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new SendInvoiceByEmail(),
        ];
    }
}

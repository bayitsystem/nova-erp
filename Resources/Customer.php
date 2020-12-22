<?php

namespace NovaModules\Erp\Resources;

use NovaModules\Erp\Actions\ClientAccountStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Customer extends Resource
{
    public static $category = 'ERP';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'NovaModules\Erp\Models\Customer';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The pagination per-page options configured for this resource.
     *
     * @return array
     */
//    public static $advancedPagination = true;
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'firstname', 'lastname'
    ];

    /*
     *  get the display name
     *  @return string
     */
    public static function label() {
        return 'Clientes';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return array(
            BelongsTo::make('Company'),

            Text::make('Firstname')
                ->sortable()
                ->rules('required'),

            Text::make('Lastname')->sortable(),

            Text::make('Address'),

            Text::make('Phone'),

            Text::make('Whatsapp'),

            Text::make('Email'),

            Trix::make('Notes'),

            Boolean::make('Solvente', 'isSolvent' )
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Deuda', 'totalOverdueInvoices')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsToMany::make('ServicePackages')->fields(function (){
                return array(
                    Date::make('Start', 'start'),
                    Date::make('End', 'end'),
                    Number::make('payday')->min(1)->max(30),
                    Number::make('payday_limit')->min(1)->max(30),
                    Boolean::make('is_activate')
                );
            }),

            MorphMany::make('Invoices'),
        );
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
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
            new DownloadExcel(),
            new ClientAccountStatement(),
        ];
    }
}

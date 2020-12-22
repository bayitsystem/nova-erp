<?php

namespace NovaModules\Erp\Resources;

use NovaModules\Erp\Actions\GenerateSubscriptionInvoices;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class ServicePackage extends Resource
{
    public static $category = 'ERP';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'NovaModules\Erp\Models\ServicePackage';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];
        /*
     *  get the display name
     *  @return string
     */
    public static function label() {
        return 'Subscripciones';
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
            ID::make()->sortable(),

            Text::make('Name')->sortable(),

            Trix::make('Description'),

            BelongsToMany::make('Services')->fields(function (){
                return [
                    Number::make('price')->min(1)->step(0.01)
                ];
            }),

            BelongsToMany::make('Customers')->fields(function (){
                return [
                    Date::make('Start'),
                    Date::make('End'),
                    Number::make('payday')->min(1)->max(30),
                    Number::make('payday_limit')->min(1)->max(30),
                    Boolean::make('is_activate')
                ];
            })
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
        return [];
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
            new GenerateSubscriptionInvoices(),
        ];
    }
}

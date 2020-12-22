<?php

namespace NovaModules\Erp\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Service extends Resource
{
    public static $displayInNavigation = false;

    public static $category = 'ERP';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'NovaModules\Erp\Models\Service';

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
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Name')->sortable(),

            Trix::make('Description'),

            BelongsTo::make('TypeOfService'),

             BelongsToMany::make('ServicePackages')->fields(function (){
                 return [
                     Number::make('price')->min(1)->step(0.01)
                 ];
             }),

            /*BelongsToMany::make('Invoices')->fields(function (){
                return [
                    Number::make('Cuantity'),

                    Number::make('Price'),

                    Number::make('Total Cost', 'total_cost')
                ];
            })*/
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
        return [];
    }
}

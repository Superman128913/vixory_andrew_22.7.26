<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

use SimpleSquid\Nova\Fields\Enum\Enum;
use \App\Enums\FieldType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;

class SportField extends Resource
{
    public static $group = 'Sports';
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\SportField';

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
        'pretty_name', 'table_name'
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
            ID::make()->sortable(),
            Text::make('Pretty Name')->sortable(),
            Text::make('Table Name')->sortable(),
            Enum::make('Type')->attachEnum(FieldType::class)->sortable(),
            Enum::make('Filter Type')->attachEnum(FieldType::class)->sortable(),
            Text::make('Mask')->hideFromIndex(),
            Text::make('Suffix')->hideFromIndex(),
            Text::make('Step')->hideFromIndex(),
            Boolean::make('Search Visible')->hideFromIndex(),
            Boolean::make('Dependent Equivalency')->help('Whether the field is hidden (false) or shown (true) when the parent field is selected.'),
            BelongsTo::make('Sport')
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
        return [
            new Filters\SportFieldType
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

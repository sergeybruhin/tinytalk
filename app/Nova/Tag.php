<?php

namespace App\Nova;

use App\Models\Tag as TagModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Tag extends Resource
{
    /**
     * @var string
     */
    public static $group = 'Система';

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Теги';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = TagModel::class;

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
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')
                ->sortable(),

            Text::make('Название', 'name'),

        ];
    }

}

<?php

namespace App\Nova;

use Benjacho\BelongsToManyField\BelongsToManyField;
use Davidpiesse\Audio\Audio;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Nikans\TextLinked\TextLinked;
use OptimistDigital\NovaSortable\Traits\HasSortableManyToManyRows;

class Word extends Resource
{
    use HasSortableManyToManyRows;

    /**
     * @var string
     */
    public static $group = ' Слова';

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Слова';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Word::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'text';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'text',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')
                ->sortable(),

            TextLinked::make('Текст', 'text')
                ->required()
                ->rules('required', 'string')
                ->link($this),

            Images::make('Картинка', 'image')
                ->croppingConfigs(['ratio' => 4 / 3])
                ->mustCrop()
                ->showStatistics()
                ->conversionOnIndexView('md') // conversion used to display the image
                ->singleMediaRules('required', 'file', 'image', 'mimes:jpg,jpeg', 'dimensions:min_width=320,min_height=320', 'max:8000')
                ->help('Формат изображения .jpg, размер не должен превышать 8МБ, минимум 320x320px')
                ->required(),

            Audio::make('Audio', 'audio')
                ->disk('audio')
                ->nullable(),

            BelongsToManyField::make('Коллекции', 'wordCollections', WordCollection::class),

//            Number::make('Порядок', 'sort_order')->displayUsing(function ($field, $resource) {
//                return $resource->sort_order;
//            }),

        ];
    }

}

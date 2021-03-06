<?php

namespace App\Nova;

use App\Models\Phrase as PhraseModel;
use Davidpiesse\Audio\Audio;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Phrase extends Resource
{

    /**
     * @var string
     */
    public static $group = ' Фразы';

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Фразы';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = PhraseModel::class;

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

            Text::make('Текст', 'text'),

            Images::make('Обложка', 'image') // second parameter is the media collection name
            ->croppingConfigs(['ratio' => 4 / 3])
                ->mustCrop()
                ->showStatistics()
                ->conversionOnIndexView('md') // conversion used to display the image
                ->rules('required')
                ->singleMediaRules(['mimes:jpg']), // validation rules

            Audio::make('Audio', 'audio')
                ->disk('audio')
                ->nullable(),
            BelongsToMany::make('Коллекции', 'phraseCollections', PhraseCollection::class),

        ];
    }

}

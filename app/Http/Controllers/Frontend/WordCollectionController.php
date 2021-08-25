<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Word;
use App\Models\WordCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class WordCollectionController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $wordCollections = WordCollection::with('words')
            ->withCount('words')
            ->orderByDesc('words_count')
            ->paginate(30);
        return view('frontend.pages.word-collections.master')
            ->with(compact('wordCollections'));
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $wordCollection = WordCollection::findOrFail($id);

        return view('frontend.pages.word-collection.master')
            ->with(compact('wordCollection'));
    }

    public function showWord($collectionId, $wordId): View
    {
        $wordCollection = WordCollection::findOrFail($collectionId);
        $word = $wordCollection->words()->find($wordId);

        $previousWord = null;
        $nextWord = null;

        if ($word) {
            // get previous user id
            $previousId = $wordCollection->words()->wherePivot('order', '<', $word->pivot->order)->max('order');
//            $previousWord = $collection->words()->find($previousId);
//            $previousId = $collection->words()->first();
//            dd($previousId);
            $previousWord = $wordCollection->words()->find($previousId);
//            $previousWord = Word::whereHas('wordCollections', function (Builder $query) use ($collectionId) {
//                return $query->where('id', $collectionId);
//            })->first();
//            $previousWord = Word::where('word-collections.id', $collectionId );
//            $previousWord = Word::whereHas('wordCollections', function($query) use ($collectionId) {
//               $query->where('id', $collectionId);
//            });

//            dd($previousWord->first());

            // get next user id
            $nextId = $wordCollection->words()->wherePivot('order', '>', $word->pivot->order)->min('order');
            $nextWord = $wordCollection->words()->find($nextId);
        }

        //        dd($previousWord->toArray(), $nextWord->toArray());

        return view('frontend.pages.word.master')
            ->with(compact('wordCollection'))
            ->with(compact('word'))
            ->with(compact('nextWord'))
            ->with(compact('previousWord'));


    }

}

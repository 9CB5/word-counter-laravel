<?php

namespace App\Http\Controllers;

use App\Models\Phrase;

class PhraseController extends Controller
{
    /**
     * Store phrases in the database
     */
    public static function store($phrases)
    {
        $phrasesData = [];

        // setup array that will be used to bulk upsert phrases
        foreach ($phrases as $phrase => $frequency) {
            $phrasesData[] = [
                "phrase" => $phrase,
                "created_at" => now(),
                "updated_at" => now()
            ];
        }

        Phrase::upsert($phrasesData, ['phrase'], ['updated_at']);  // bulk upsert keywords
    }

    /**
     * Sets the relationship between website and phrase
     */
    public static function attachPhrasesToWebsite($phrases, $website, $totalWordCount)
    {
        // get id of phrases that got upserted
        $phrasesIds = Phrase::whereIn('phrase', array_keys($phrases))->pluck('id', 'phrase');

        $pivotData = [];

        foreach ($phrases as $word => $frequency) {
            $density = ($frequency / $totalWordCount) * 100;  // calculate density as a percentage

            $pivotData[] = [
                "phrase_id" => $phrasesIds[$word],
                "website_id" => $website->id,
                "frequency" => $frequency,
                "density" => round($density), // round to nearest whole number
                "created_at" => now(),
                "updated_at" => now()
            ];
        }

        $website->phrases()->syncWithoutDetaching($pivotData);  // bulk insert to pivot table
    }
}

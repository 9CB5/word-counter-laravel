<?php

namespace App\Http\Controllers;

use App\Models\Keyword;

class KeywordController extends Controller
{
    /**
     * Stores the keywords in the database
     */
    public static function store($keywords)
    {
        $keywordsData = [];

        // setup array that will be used to bulk upsert keywords
        foreach ($keywords as $word => $frequency) {
            $keywordsData[] = [
                "keyword" => $word,
                "created_at" => now(),
                "updated_at" => now()
            ];
        }

        Keyword::upsert($keywordsData, ['keyword'], ['updated_at']);  // bulk upsert keywords
    }

    /**
     * Forms the relationship between website and keywords
     */
    public static function attachKeywordsToWebsite($keywords, $website, $totalWordCount)
    {
        // get id of keywords that got upserted
        $keywordIds = Keyword::whereIn('keyword', array_keys($keywords))->pluck('id', 'keyword');

        $pivotData = [];

        foreach ($keywords as $word => $frequency) {
            $density = ($frequency / $totalWordCount) * 100;  // calculate density as a percentage

            $pivotData[] = [
                "keyword_id" => $keywordIds[$word],
                "website_id" => $website->id,
                "frequency" => $frequency,
                "density" => round($density), // round to nearest whole number
                "created_at" => now(),
                "updated_at" => now()
            ];
        }

        $website->keywords()->syncWithoutDetaching($pivotData);  // bulk insert to pivot table
    }
}

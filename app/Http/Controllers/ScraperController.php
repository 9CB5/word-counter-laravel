<?php

namespace App\Http\Controllers;

use App\Models\Website;

use App\Http\Controllers\KeywordController;
use App\Http\Controllers\PhraseController;

class ScraperController extends Controller
{
    /**
     * Scrape contents of a static website
     */
    public static function scrapeWebsite($url)
    {
        // scrape website and clean extracted data before processing
        // ----------------------------------------------------------------------------------------
        $htmlText = self::getHtmlText($url);  // fetch website data
        $words = self::getWords($htmlText);  // get all words in the form of array
        $wordsWithoutCommon = self::getWordsWithoutCommon($words);  // filter common words

        // update the total word count of an existing website
        // ----------------------------------------------------------------------------------------
        $totalWordCount = sizeof($words);
        $website = Website::where("url", $url)->firstOrFail();
        $website->update(["total_word_count" => $totalWordCount]);

        // count keywords, store to database then setup the relationships
        // ----------------------------------------------------------------------------------------
        $keywords = self::countKeywords($wordsWithoutCommon);
        KeywordController::store($keywords);
        KeywordController::attachKeywordsToWebsite($keywords, $website, $totalWordCount);

        // count phrases, store to database then setup the relationships
        // ----------------------------------------------------------------------------------------
        $phrases = self::countPhrases($wordsWithoutCommon);
        PhraseController::store($phrases);
        PhraseController::attachPhrasesToWebsite($phrases, $website, $totalWordCount);
    }

    /**
     * Use curl to get html body text
     */
    public static function getHtmlText($url)
    {
        $output = "";
        $ch = curl_init();  // initalise curl

        // curl configuration
        // ----------------------------------------------------------------------------------------
        curl_setopt($ch, CURLOPT_URL, $url);  // url to fetch
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // return as string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // follow any redirects
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  // skip ssl verification if needed

        $html = curl_exec($ch); // begin the fetch

        if (curl_errno($ch)) {
            throw new \Exception('Error:' . curl_error($ch));
        }

        curl_close($ch); // close curl session
        $output = strip_tags($html); // remove html tags;

        return $output;
    }

    /**
     * Clean text then returns an array of words ready for processing
     */
    public static function getWords($htmlText)
    {
        $output = [];

        // clean up text
        // ----------------------------------------------------------------------------------------
        $cleanText = trim($htmlText);  // remove leading and trailing spaces
        $cleanText = strtolower($cleanText);  // convert to lowercase
        $cleanText = preg_replace('/[^a-z\s]/', '', $cleanText);  // remove special characters
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);  // replace multiple spaces with a single space

        $output = explode(" ", $cleanText);  // split text into array of words

        return $output;
    }

    /**
     * Removes common words
     */
    public static function getWordsWithoutCommon($words)
    {
        $output = [];

        // common words to filter out
        $common = ["the", "on", "and", "a", "in", "of", "from", "to", "at", "this", "is"];

        // filter out common words
        $output = array_filter($words, function ($word) use ($common) {
            return !in_array($word, $common);
        });

        $output = array_values($output); // reindex the array to have sequential keys

        return $output;
    }

    /**
     * Tallies keywords
     */
    public static function countKeyWords($wordsWithoutCommon)
    {
        $maxWords = 10;
        $output = [];
        $wordFrequency = [];

        // group words together
        foreach ($wordsWithoutCommon as $word) {
            if ($word) {
                // increment the word count, initializing to 0 if it doesn't exist
                $wordFrequency[$word] = isset($wordFrequency[$word]) ? $wordFrequency[$word] + 1 : 1;
            }
        }

        arsort($wordFrequency);  // sort by value in desc order
        $output = array_slice($wordFrequency, 0, $maxWords, true);  // get top 10 by slicing first 10 elements

        return $output;
    }

    /**
     * Generates the phrase then tallies them
     */
    public static function countPhrases($wordsWithoutCommon)
    {
        $maxPhrases = 10;
        $output = [];
        $phraseFrequency = [];

        // count occurrences of two-word phrases
        $count = count($wordsWithoutCommon);
        for ($i = 0; $i < $count - 1; $i++) {

            // create a two-word phrase by combining current and next word
            $phrase = $wordsWithoutCommon[$i] . ' ' . $wordsWithoutCommon[$i + 1];

            // increment the phrase count, initialise to 0 if it doesn't exist
            if (isset($phraseFrequency[$phrase])) {
                $phraseFrequency[$phrase]++;
            } else {
                $phraseFrequency[$phrase] = 1;
            }
        }

        // form two-word phrases
        for ($i = 0; $i < count($wordsWithoutCommon) - 1; $i++) {
            // check if both current and next words are not empty
            if (isset($wordsWithoutCommon[$i]) && isset($wordsWithoutCommon[$i + 1])) {
                $phrases[] = $wordsWithoutCommon[$i] . ' ' . $wordsWithoutCommon[$i + 1];
            }
        }

        // count number of occurence of each phrase
        foreach ($phrases as $phrase) {
            if (isset($phraseFrequency[$phrase])) {
                $phraseFrequency[$phrase]++;
            } else {
                $phraseFrequency[$phrase] = 1;
            }
        }

        arsort($phraseFrequency);  // sort by frequency in descending order
        $output = array_slice($phraseFrequency, 0, $maxPhrases, true); // get top 10 by slicing first 10 elements

        return $output;
    }
}

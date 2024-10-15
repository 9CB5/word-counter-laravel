<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ScraperController;

use App\Models\Website;

class WebsiteController extends Controller
{
    /**
     * Returns the view for creating websites
     */
    public function create()
    {
        return view("website.create");
    }

    /**
     * Returns the view for creating websites
     */
    public function index()
    {
        $websites = Website::with(["keywords", "phrases"])
            ->orderBy('created_at', 'desc')
            ->simplePaginate(5);

        return view("website.index", [
            "websites" => $websites
        ]);
    }

    /**
     * Returns the view for creating websites
     */
    public function show(Website $website)
    {
        $website->load(["keywords", "phrases"]);

        return view("website.show", ["website" => $website]);
    }

    /**
     * Store one or more website in the database
     */
    public function store()
    {
        $urls = [];

        // remove token and include only valid URL's
        foreach (request()->all() as $key => $value) {
            if ($key !== '_token' && !is_null($value) && $this->isValidUrl($value)) {
                $urls[] = $value;
            }
        }

        $urls = array_unique($urls); // filter duplicated url inputs

        foreach($urls as $url) {
            if (!Website::where('url', $url)->exists()) {
                Website::insert([
                    "url" => $url,
                    "total_word_count" => 0,
                    "created_at" => now(),
                    "updated_at" => now()
                ]);

                // call the scraper for the new URL
                ScraperController::scrapeWebsite($url);
            }
        }

        return redirect("/websites");
    }

    /**
     * Checks whether a URL returns a 200 and therefore scrapable
     */
    private function isValidUrl($url) {
        $headers = @get_headers($url);  // get header of a url

        // if url returns a code of 200, it's a working URL
        if ($headers && strpos( $headers[0], "200")) {
            return true;
        }

        return false;
    }
}

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ScraperController;

use App\Models\Website;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Website routes
// ================================================================================================
Route::get("/", [WebsiteController::class, "create"]);
Route::get("/websites", [WebsiteController::class, "index"])->name("websites.index");
Route::get("/websites/{website}", [WebsiteController::class, "show"]);

Route::post("/websites", [WebsiteController::class, "store"]);

// Scraper routes
// ================================================================================================
Route::post("/scrape", [ScraperController::class, "scrapeWebsite"]);
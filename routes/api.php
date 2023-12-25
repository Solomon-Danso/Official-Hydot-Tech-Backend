<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteHomeController;
use App\Http\Controllers\SiteAboutController;
use App\Http\Controllers\SiteServiceController;
use App\Http\Controllers\SitePortfolioController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("siteHome",[SiteHomeController::class,'Home']);
Route::get("getHome",[SiteHomeController::class,'GetHome']);

Route::post("siteAbout",[SiteAboutController::class,'About']);
Route::get("getAbout",[SiteAboutController::class,'GetAbout']);

Route::post("siteService",[SiteServiceController::class,'Service']);
Route::get("getService",[SiteServiceController::class,'GetService']);

Route::post("sitePortfolio",[SitePortfolioController::class,'Portfolio']);
Route::get("getPortfolioAll",[SitePortfolioController::class,'GetAllProducts']);
Route::get("getPortfolio/{PrdId}",[SitePortfolioController::class,'GetSingleProduct']);
Route::post('portfolio/{PrdId}', [SitePortfolioController::class,'UpdateProduct']);
Route::delete('deletePortfolio/{PrdId}', [SitePortfolioController::class,'DeletePortfolio']);








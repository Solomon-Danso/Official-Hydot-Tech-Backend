<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteHomeController;
use App\Http\Controllers\SiteAboutController;
use App\Http\Controllers\SiteServiceController;
use App\Http\Controllers\SitePortfolioController;
use App\Http\Controllers\SiteContactController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\SiteSocialMediaController;

use App\Http\Controllers\AuthenticationController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("siteHome",[SiteHomeController::class,'Home']);
Route::get("getHome",[SiteHomeController::class,'GetHome']);

Route::post("siteAbout",[SiteAboutController::class,'About']);
Route::get("getAbout",[SiteAboutController::class,'GetAbout']);

Route::post("siteService",[SiteServiceController::class,'Service']);
Route::get("getService",[SiteServiceController::class,'GetService']);


Route::post("siteContact",[SiteContactController::class,'Contact']);
Route::get("getContact",[SiteContactController::class,'GetContact']);

Route::post("Contact",[ContactsController::class,'SendMessage']);
Route::get("getContact",[ContactsController::class,'GetAllMessages']);
Route::post("replyContact/{Id}",[ContactsController::class,'ReplyMessage']);
Route::delete("deleteContact/{Id}",[ContactsController::class,'Deleter']);

Route::post("Social",[SiteSocialMediaController::class,'Social']);
Route::get("getSocial",[SiteSocialMediaController::class,'GetMedia']);
Route::delete("deleteMedia/{Id}",[SiteSocialMediaController::class,'DeleteMedia']);

Route::post("SignUp/{token}",[AuthenticationController::class,'SignUp']);
Route::post("LogIn",[AuthenticationController::class,'LogIn']);
Route::post("VerifyToken/{userId}/{token}",[AuthenticationController::class,'VerifyToken']);
Route::get("UnLock/{email}",[AuthenticationController::class,'Unlocker']);
Route::get("SignUpToken",[AuthenticationController::class,'SignUpToken']);


Route::post("sitePortfolio",[SitePortfolioController::class,'Portfolio']);
Route::get("getPortfolioAll",[SitePortfolioController::class,'GetAllProducts']);
Route::get("getPortfolio/{PrdId}",[SitePortfolioController::class,'GetSingleProduct']);
Route::post('portfolio/{PrdId}', [SitePortfolioController::class,'UpdateProduct']);
Route::delete('deletePortfolio/{PrdId}', [SitePortfolioController::class,'DeletePortfolio']);








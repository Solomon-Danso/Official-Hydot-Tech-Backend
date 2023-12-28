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
use App\Http\Controllers\PTargetController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PStrategyController;
use App\Http\Controllers\PSourceController;
use App\Http\Controllers\PRecieveController;
use App\Http\Controllers\PAssetController;
use App\Http\Controllers\PDebtController;
use App\Http\Controllers\PJobController;
use App\Http\Controllers\PSavingController;













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


Route::post("CreateTarget",[PTargetController::class,'CreateTarget']);
Route::post("UpdateTarget/{Id}",[PTargetController::class,'UpdateTarget']);
Route::get("GetTarget/{Section}",[PTargetController::class,'GetTarget']);
Route::delete("DeleteTarget/{Id}",[PTargetController::class,'DeleteTarget']);


Route::post("CreateStrategy",[PStrategyController::class,'CreateStrategy']);
Route::post("UpdateStrategy/{Id}",[PStrategyController::class,'UpdateStrategy']);
Route::get("GetStrategy/{Section}",[PStrategyController::class,'GetStrategy']);
Route::delete("DeleteStrategy/{Id}",[PStrategyController::class,'DeleteStrategy']);


Route::post("CreateSource",[PSourceController::class,'CreateSource']);
Route::post("UpdateSource/{Id}",[PSourceController::class,'UpdateSource']);
Route::get("GetSource/{Section}",[PSourceController::class,'GetSource']);
Route::delete("DeleteSource/{Id}",[PSourceController::class,'DeleteSource']);


Route::post("CreateRecieve",[PRecieveController::class,'CreateRecieve']);
Route::post("UpdateRecieve/{Id}",[PRecieveController::class,'UpdateRecieve']);
Route::get("GetRecieve/{Section}",[PRecieveController::class,'GetRecieve']);
Route::delete("DeleteRecieve/{Id}",[PRecieveController::class,'DeleteRecieve']);


Route::post("CreateAsset",[PAssetController::class,'CreateAsset']);
Route::post("UpdateAsset/{Id}",[PAssetController::class,'UpdateAsset']);
Route::get("GetAsset/{Section}",[PAssetController::class,'GetAsset']);
Route::delete("DeleteAsset/{Id}",[PAssetController::class,'DeleteAsset']);

Route::post("CreateDebt",[PDebtController::class,'CreateDebt']);
Route::post("UpdateDebt/{Id}",[PDebtController::class,'UpdateDebt']);
Route::get("GetDebt/{Section}",[PDebtController::class,'GetDebt']);
Route::delete("DeleteDebt/{Id}",[PDebtController::class,'DeleteDebt']);

Route::post("CreateJob",[PJobController::class,'CreateJob']);
Route::post("UpdateJob/{Id}",[PJobController::class,'UpdateJob']);
Route::get("GetJob/{Section}",[PJobController::class,'GetJob']);
Route::delete("DeleteJob/{Id}",[PJobController::class,'DeleteJob']);


Route::post("CreateSaving",[PSavingController::class,'CreateSaving']);
Route::post("UpdateSaving/{Id}",[PSavingController::class,'UpdateSaving']);
Route::get("GetSaving/{Section}",[PSavingController::class,'GetSaving']);
Route::delete("DeleteSaving/{Id}",[PSavingController::class,'DeleteSaving']);

Route::get("GetSavingD",[PSavingController::class,'GetSavingD']);




















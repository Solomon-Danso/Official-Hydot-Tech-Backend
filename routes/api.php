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
use App\Http\Controllers\PConfigController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectCodeController;










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
Route::get("GetTargetName",[PTargetController::class,'GetTargetName']);
Route::get("GetTargetAmnt",[PTargetController::class,'GetTargetAmnt']);


Route::post("CreateStrategy",[PStrategyController::class,'CreateStrategy']);
Route::post("UpdateStrategy/{Id}",[PStrategyController::class,'UpdateStrategy']);
Route::get("GetStrategy/{Section}",[PStrategyController::class,'GetStrategy']);
Route::delete("DeleteStrategy/{Id}",[PStrategyController::class,'DeleteStrategy']);
Route::get("GetStrategyName",[PStrategyController::class,'GetStrategyName']);
Route::get("GetStrategyAmnt",[PStrategyController::class,'GetStrategyAmnt']);


Route::post("CreateSource",[PSourceController::class,'CreateSource']);
Route::post("UpdateSource/{Id}",[PSourceController::class,'UpdateSource']);
Route::get("GetSource/{Section}",[PSourceController::class,'GetSource']);
Route::delete("DeleteSource/{Id}",[PSourceController::class,'DeleteSource']);
Route::get("GetSourceName",[PSourceController::class,'GetSourceName']);
Route::get("GetSourceAmnt",[PSourceController::class,'GetSourceAmnt']);







Route::post("CreateRecieve",[PRecieveController::class,'CreateRecieve']);
Route::post("UpdateRecieve/{Id}",[PRecieveController::class,'UpdateRecieve']);
Route::get("GetRecieve/{Section}",[PRecieveController::class,'GetRecieve']);
Route::delete("DeleteRecieve/{Id}",[PRecieveController::class,'DeleteRecieve']);
Route::get("GetRecieveName",[PRecieveController::class,'GetRecieveName']);
Route::get("GetRecieveAmnt",[PRecieveController::class,'GetRecieveAmnt']);



Route::post("CreateAsset",[PAssetController::class,'CreateAsset']);
Route::post("UpdateAsset/{Id}",[PAssetController::class,'UpdateAsset']);
Route::get("GetAsset/{Section}",[PAssetController::class,'GetAsset']);
Route::delete("DeleteAsset/{Id}",[PAssetController::class,'DeleteAsset']);
Route::get("GetAssetName",[PAssetController::class,'GetAssetName']);
Route::get("GetAssetAmnt",[PAssetController::class,'GetAssetAmnt']);




Route::post("CreateDebt",[PDebtController::class,'CreateDebt']);
Route::post("UpdateDebt/{Id}",[PDebtController::class,'UpdateDebt']);
Route::get("GetDebt/{Section}",[PDebtController::class,'GetDebt']);
Route::delete("DeleteDebt/{Id}",[PDebtController::class,'DeleteDebt']);
Route::get("GetDebtName",[PDebtController::class,'GetDebtName']);
Route::get("GetDebtAmnt",[PDebtController::class,'GetDebtAmnt']);


Route::post("CreateJob",[PJobController::class,'CreateJob']);
Route::post("UpdateJob/{Id}",[PJobController::class,'UpdateJob']);
Route::get("GetJob/{Section}",[PJobController::class,'GetJob']);
Route::delete("DeleteJob/{Id}",[PJobController::class,'DeleteJob']);
Route::get("GetJobName",[PJobController::class,'GetJobName']);
Route::get("GetJobAmnt",[PJobController::class,'GetJobAmnt']);

Route::get("CountAllProject",[ProjectCodeController::class,'CountAllProject']);
Route::get("SumAllClients",[ProjectCodeController::class,'SumAllClients']);
Route::get("SumAllPayment",[ProjectCodeController::class,'SumAllPayment']);
Route::get("TopFiveMostViewedName",[ProjectCodeController::class,'TopFiveMostViewedName']);
Route::get("TopFiveMostViewedValue",[ProjectCodeController::class,'TopFiveMostViewedValue']);
Route::get("TopFiveMostPayedName",[ProjectCodeController::class,'TopFiveMostPayedName']);
Route::get("TopFiveMostPayedValue",[ProjectCodeController::class,'TopFiveMostPayedValue']);
Route::get("GetAuditTrial",[ClientController::class,'GetAuditTrial']);
Route::get("GetTodayAuditTrial",[ClientController::class,'GetTodayAuditTrial']);


Route::get("Test",[ProjectCodeController::class,'Test']);
















Route::post("CreateSaving",[PSavingController::class,'CreateSaving']);
Route::post("UpdateSaving/{Id}",[PSavingController::class,'UpdateSaving']);
Route::get("GetSaving/{Section}",[PSavingController::class,'GetSaving']);
Route::delete("DeleteSaving/{Id}",[PSavingController::class,'DeleteSaving']);

Route::get("GetSavingD",[PSavingController::class,'GetSavingD']);

Route::post("CreateConfig",[PConfigController::class,'CreateConfig']);
Route::post("UpdateConfig/{Id}",[PConfigController::class,'UpdateConfig']);
Route::get("GetConfig/{Section}",[PConfigController::class,'GetConfig']);
Route::delete("DeleteConfig/{Id}",[PConfigController::class,'DeleteConfig']);
Route::get("GetConfigD",[PConfigController::class,'GetConfigD']);


Route::post("RegisterCompany",[ClientController::class,'RegisterCompany']);
Route::post("UpdateCompany/{CompanyId}",[ClientController::class,'UpdateCompany']);
Route::get("GetCompany",[ClientController::class,'GetCompany']);
Route::post("SearchCompany",[ClientController::class,'SearchCompany']);
Route::get("GetOneCompany/{CompanyId}",[ClientController::class,'GetOneCompany']);
Route::delete("DeleteCompany/{CompanyId}",[ClientController::class,'DeleteCompany']);



Route::post("bulkUpload",[ClientController::class,'bulkUpload']);
Route::post("CompanyToken",[ClientController::class,'CompanyToken']);
Route::post("PricesConfiguration",[ClientController::class,'PricesConfiguration']);
Route::post("UpdatePricesConfiguration/{ProductId}",[ClientController::class,'UpdatePricesConfiguration']);
Route::delete("DeletePricesConfiguration/{ProductId}",[ClientController::class,'DeletePricesConfiguration']);
Route::get("GetPricesConfiguration",[ClientController::class,'GetPricesConfiguration']);


Route::post("CreatePaymentHub/{CompanyId}",[ClientController::class,'CreatePaymentHub']);
Route::get("GetPayment",[ClientController::class,'GetPayment']);
Route::get("GetOnePayment/{CompanyId}",[ClientController::class,'GetOnePayment']);


Route::post("CreateProject",[ProjectCodeController::class,'CreateProject']);
Route::post("UpdateProject/{id}",[ProjectCodeController::class,'UpdateProject']);
Route::delete("DeleteProject/{id}",[ProjectCodeController::class,'DeleteProject']);
Route::get("AllProject",[ProjectCodeController::class,'AllProject']);












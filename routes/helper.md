Route::post("CreateConfig",[PConfigController::class,'CreateConfig']);
Route::post("UpdateConfig/{Id}",[PConfigController::class,'UpdateConfig']);
Route::get("GetConfig/{Section}",[PConfigController::class,'GetConfig']);
Route::delete("DeleteConfig/{Id}",[PConfigController::class,'DeleteConfig']);

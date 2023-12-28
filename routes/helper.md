Route::post("CreateSaving",[PSavingController::class,'CreateSaving']);
Route::post("UpdateSaving/{Id}",[PSavingController::class,'UpdateSaving']);
Route::get("GetSaving/{Section}",[PSavingController::class,'GetSaving']);
Route::delete("DeleteSaving/{Id}",[PSavingController::class,'DeleteSaving']);

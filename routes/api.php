<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get("/emoji", [ApiController::class, "index"]);

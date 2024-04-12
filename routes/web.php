<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;


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

Route::redirect('/', '/upload');

Route::get('/upload', [ImageController::class, 'createForm']);
Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');
Route::get('/list-images',[ImageController::class, 'showUploadedImages'])->name('image.list');
Route::post('/images/download',[ImageController::class,'downloadZip'])->name('images.download');

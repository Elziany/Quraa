<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Auth\AuthController;
 use App\Http\Controllers\Auth\SocialAuthController;
 use App\Http\Controllers\Article\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'user'],function()
{

Route::post('/register',[AuthController::class,'userRegisteration']);
Route::post('/login',[AuthController::class,'userLogin']);

#############Social Authuntication (google,linkedin)#########
Route::get('/redirect/{provider}',[SocialAuthController::class,'redirect']);
Route::get('/{provider}/callback',[SocialAuthController::class,'callback']);

});

Route::group(['prefix'=>'article','middleware'=>'auth:sanctum'],function(){
Route::post('createArticle',[ArticleController::class,'createArticle']);
Route::get('getArticles',[ArticleController::class,'getArticles']);
});

/* Route::group(['middleware'=>'auth:sanctum'],function(){
Route::get('test',function(){
    return response()->json(request()->user());
});
}); */

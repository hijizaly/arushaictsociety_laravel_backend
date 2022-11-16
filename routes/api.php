<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/member-ship', function (Request $request) {
//    return $request->user();
//});
//Route::middleware('auth:api')->prefix('v1')->group(function (){
//    Route::get('/members',function (Request $request){
//       return
//    });
//});
//Route::group(['middleware' => \App\Http\Middleware\Authenticate::class, 'prefix' => 'v1'],
//    function () {
//        //Member Endpoints
//        Route::post('/test', [\App\Http\Controllers\MembersController::class, 'testEnd']);
//        Route::get('/test', [\App\Http\Controllers\MembersController::class, 'testEnd'])->name('just');
//        //System user Endpoints
//        Route::post('/login', [\App\Http\Controllers\MembersController::class, 'memberLogin'])->name('memberLogin');
//    });

//////
Route::group(['prefix' => 'v1'], function () {
    ///Members
    Route::post('/memberlogin', [\App\Http\Controllers\MembersController::class, 'memberLogin'])->name('memberLogin');
    Route::post('/memberregister', [\App\Http\Controllers\MembersController::class, 'membersRegistration']);
    //TODO: implement route to allow member to update occupation ID when he/she need and keep record in timelineTable
    ///Skills
    Route::get('/skills',[\App\Http\Controllers\SkillsController::class,'index'])->name('allSkills');
    ///users
    Route::post('/userlogin', [\App\Http\Controllers\UsersController::class, 'userLogin'])->name('userLogin');
    Route::post('/userregister', [\App\Http\Controllers\UsersController::class, 'usersRegistration']);


});
//////secured_Members_endpoint
Route::group(['middleware' => \App\Http\Middleware\AuthenticateMembers::class, 'prefix' => 'v1'], function () {
    Route::get('/allmember', [\App\Http\Controllers\MembersController::class, 'index']);
    Route::post('/memberlogout', [\App\Http\Controllers\MembersController::class, 'memberLogout'])->name('memberLogout');
});
/////secured_Users_endpoint
Route::group(['middleware' => \App\Http\Middleware\Authenticate::class, 'prefix' => 'v1'], function () {
    Route::post('/user', [\App\Http\Controllers\UsersController::class, 'userDetails']);
    Route::post('/userlogout', [\App\Http\Controllers\UsersController::class, 'usersLogout'])->name('usersLogout');
    ///Skills
    Route::post('/skills',[\App\Http\Controllers\SkillsController::class,'store'])->name('addSkill');
    Route::patch('/skills',[\App\Http\Controllers\SkillsController::class,'update'])->name('updateSkill');
});

Route::view(
    'memberlogin', 'memberlogin'
)->name('memberlogin_');
Route::get('/tt', function (){return "samaki";})->name('tt');





//Route::get('/not',\App\Http\Controllers\MembersController::class)->name('out');




//Route::post('/register', [\App\Http\Controllers\MembersController::class, 'membersRegistration']);
//Route::post('/login', [\App\Http\Controllers\MembersController::class, 'memberLogin'])->name('memberLogin');

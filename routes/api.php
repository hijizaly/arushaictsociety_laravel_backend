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


//////,'middleware'=> \App\Http\Middleware\Cors::class
Route::group(['prefix' => 'v1'], function () {
    ///Members
    Route::post('/memberlogin', [\App\Http\Controllers\MembersController::class, 'memberLogin'])->name('memberLogin');
    Route::post('/memberregister', [\App\Http\Controllers\MembersController::class, 'membersRegistration']);
    Route::get('/allmember', [\App\Http\Controllers\MembersController::class, 'index']);
    Route::get('/unauthorized',[\App\Http\Controllers\MembersController::class,'unauthorized'])->name('unauthorized');

    //TODO: implement route to allow member to update occupation ID when he/she need and keep record in timelineTable

    ///Skills
    Route::get('/skills',[\App\Http\Controllers\SkillsController::class,'index'])->name('allSkills');
    ///users
    Route::post('/adminlogin', [\App\Http\Controllers\UsersController::class, 'userLogin'])->name('userLogin');
    Route::post('/userregister', [\App\Http\Controllers\UsersController::class, 'usersRegistration']);
    Route::post('/forgetpassword',[\App\Http\Controllers\MembersController::class,'passwordforget'])->name('membersPasswordReset');
    Route::post('/forgetpassword/{hashUrl}',[\App\Http\Controllers\MembersController::class,'passwordreseter']);
    Route::post('/emailexistence',[\App\Http\Controllers\MembersController::class,'emailExistenceCheck'])->name('emailExistenceCheck');
    //contents
    Route::get('/contents',[\App\Http\Controllers\ContentsController::class,'index'])->name('allContents');
    Route::get('/contentsIds',[\App\Http\Controllers\ContentsController::class,'allContentsIds'])->name('allContentsIds');
    Route::get('/contents/{contentId}',[\App\Http\Controllers\ContentsController::class,'eachContent'])->name('eachContentsIds');
    //TODO it Here Tempo just move into secure area
    Route::post('/contents',[\App\Http\Controllers\ContentsController::class,'createContents'])->name('storeContents');




});
//////secured_Members_endpoint
Route::group(['middleware' => \App\Http\Middleware\AuthenticateMembers::class, 'prefix' => 'v1'], function () {
//    Route::get('/allmember', [\App\Http\Controllers\MembersController::class, 'index'])->name('allMembersRegistered');
    Route::post('/memberlogout', [\App\Http\Controllers\MembersController::class, 'memberLogout'])->name('memberLogout');
    Route::patch('/members/{memberId}',[\App\Http\Controllers\MembersController::class,'update'])->name('memberUpdate');
    Route::get('/members/{memberId}',[\App\Http\Controllers\MembersController::class,'show'])->name('membersDetails');

    Route::get('/timeline',[\App\Http\Controllers\MemberTimelineController::class,'index'])->name('membersTimeline');

//    Route::post('/otherskills',[\App\Http\Controllers\MembersOtherSkillsController::class,'create'])->name('createMemberOtherSkills');
    Route::post('/otherskills',[\App\Http\Controllers\MembersOtherSkillsController::class,'update'])->name('updateMemberOtherSkills');
    Route::delete('/otherskills',[\App\Http\Controllers\MembersOtherSkillsController::class,'destroy'])->name('deleteMemberOtherSkills');
    Route::get('/otherskills',[App\Http\Controllers\MembersOtherSkillsController::class,'index'])->name('memberAllOtherSkills');
    Route::post('/changepassword',[\App\Http\Controllers\MembersController::class,'passwordchange'])->name('membersPasswordChange');

});

/////secured_Admin_endpoint
Route::group(['middleware' => \App\Http\Middleware\Authenticate::class, 'prefix' => 'v1'], function () {
    Route::post('/admin', [\App\Http\Controllers\UsersController::class, 'userDetails']);
    Route::post('/adminlogout', [\App\Http\Controllers\UsersController::class, 'usersLogout'])->name('usersLogout');
    ///Skills
    Route::post('/skills',[\App\Http\Controllers\SkillsController::class,'store'])->name('addSkill');
    Route::patch('/skills/{skillId}',[\App\Http\Controllers\SkillsController::class,'update'])->name('updateSkill');
    //Members Management
    //Content

});

Route::view(
    'memberlogin', 'memberlogin'
)->name('memberlogin_');
Route::get('/tt', function (){return "you dont have right token for this";})->name('tt');





//Route::get('/not',\App\Http\Controllers\MembersController::class)->name('out');




//Route::post('/register', [\App\Http\Controllers\MembersController::class, 'membersRegistration']);
//Route::post('/login', [\App\Http\Controllers\MembersController::class, 'memberLogin'])->name('memberLogin');

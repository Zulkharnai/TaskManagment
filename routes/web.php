<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProductivitiesController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/LoginUser', [AuthController::class, 'LoginUser'])->name('LoginUser');

Route::group(['prefix'=> 'ControlPanel', 'middleware'=> 'AuthMiddleware'], function()
{
    Route::get('/Dashboard', [AuthController::class, 'Dashboard'])->name('Dashboard');

    Route::get('/Admin', [AdminController::class, 'Admin'])->name('Admin');
    Route::post('/AdminStore', [AdminController::class, 'AdminStore'])->name('AdminStore');
    Route::get('/AdminShow', [AdminController::class, 'AdminShow'])->name('AdminShow');
    Route::get('/AdminEdit', [AdminController::class, 'AdminEdit'])->name('AdminEdit');
    Route::get('/AdminDelete', [AdminController::class, 'AdminDelete'])->name('AdminDelete');

    Route::get('/AdminGroup', [AdminController::class, 'AdminGroup'])->name('AdminGroup');
    Route::get('/AdminGroupShow', [AdminController::class, 'AdminGroupShow'])->name('AdminGroupShow');
    Route::post('/AdminGroupStore', [AdminController::class, 'AdminGroupStore'])->name('AdminGroupStore');
    Route::get('/AdminGroupEdit', [AdminController::class, 'AdminGroupEdit'])->name('AdminGroupEdit');
    Route::get('/AdminGroupDelete', [AdminController::class, 'AdminGroupDelete'])->name('AdminGroupDelete');

    Route::get('/Categories', [CategoriesController::class, 'Categories'])->name('Categories');
    Route::get('/CategoriesShow', [CategoriesController::class, 'CategoriesShow'])->name('CategoriesShow');
    Route::get('/CategoriesEdit', [CategoriesController::class, 'CategoriesEdit'])->name('CategoriesEdit');
    Route::post('/CategoriesStore', [CategoriesController::class, 'CategoriesStore'])->name('CategoriesStore');
    Route::get('/CategoriesDelete', [CategoriesController::class, 'CategoriesDelete'])->name('CategoriesDelete');

    Route::get('/TeamMember', [TeamMemberController::class, 'TeamMember'])->name('TeamMember');
    Route::get('/TeamMemberShow', [TeamMemberController::class, 'TeamMemberShow'])->name('TeamMemberShow');
    Route::get('/TeamMemberEdit', [TeamMemberController::class, 'TeamMemberEdit'])->name('TeamMemberEdit');
    Route::get('/TeamMemberDelete', [TeamMemberController::class, 'TeamMemberDelete'])->name('TeamMemberDelete');
    Route::post('/TeamMemberStore', [TeamMemberController::class, 'TeamMemberStore'])->name('TeamMemberStore');

    Route::get('/Designation', [TeamMemberController::class, 'Designation'])->name('Designation');
    Route::post('/DesignationStore', [TeamMemberController::class, 'DesignationStore'])->name('DesignationStore');
    Route::get('/DesignationShow', [TeamMemberController::class, 'DesginationShow'])->name('DesignationShow');
    Route::get('/DesignationEdit', [TeamMemberController::class, 'DesignationEdit'])->name('DesignationEdit');
    Route::get('/DesignationDelete', [TeamMemberController::class, 'DesignationDelete'])->name('DesignationDelete');

    Route::get('/Project', [ProjectController::class, 'Project'])->name('Project');
    Route::get('/ProjectShow', [ProjectController::class, 'ProjectShow'])->name('ProjectShow');
    Route::post('/ProjectStore', [ProjectController::class, 'ProjectStore'])->name('ProjectStore');
    Route::get('/ProjectEdit', [ProjectController::class, 'ProjectEdit'])->name('ProjectEdit');
    Route::get('/ProjectDelete', [ProjectController::class, 'ProjectDelete'])->name('ProjectDelete');

    Route::get('/Productivities', [ProductivitiesController::class, 'Productivities'])->name('Productivities');
    Route::get('/ProductivitiesShow', [ProductivitiesController::class, 'ProductivitiesShow'])->name('ProductivitiesShow');
    Route::get('/ProductivitiesEdit', [ProductivitiesController::class, 'ProductivitiesEdit'])->name('ProductivitiesEdit');
    Route::post('/ProductivitiesStore', [ProductivitiesController::class, 'ProductivitiesStore'])->name('ProductivitiesStore');
    Route::get('/ProductivitiesDelete', [ProductivitiesController::class, 'ProductivitiesDelete'])->name('ProductivitiesDelete');

    Route::get('/Task', [TaskController::class, 'Task'])->name('Task');
    Route::get('/TaskShow', [TaskController::class, 'TaskShow'])->name('TaskShow');
    Route::post('/TaskStore', [TaskController::class, 'TaskStore'])->name('TaskStore');
    Route::get('/TaskEdit', [TaskController::class, 'TaskEdit'])->name('TaskEdit');
    Route::get('/TaskDelete', [TaskController::class, 'TaskDelete'])->name('TaskDelete');


    // Employee Logins
    Route::get('/EmployeeDashboard', [AuthController::class, 'EmployeeDashboard'])->name('EmployeeDashboard');

    Route::get('/EmployeeTask', [TaskController::class, 'EmployeeTask'])->name('EmployeeTask');
    Route::get('/EmployeeTaskShow', [TaskController::class, 'EmployeeTaskShow'])->name('EmployeeTaskShow');
    Route::post('/EmployeeTaskStore', [TaskController::class, 'EmployeeTaskStore'])->name('EmployeeTaskStore');

    Route::get('/Completed', [TaskController::class, 'Completed'])->name('Completed');
    Route::get('/CompletedTaskShow', [TaskController::class, 'CompletedTaskShow'])->name('CompletedTaskShow');

    Route::get('/Pending', [TaskController::class, 'Pending'])->name('Pending');
    Route::get('/PendingTaskShow', [TaskController::class, 'PendingTaskShow'])->name('PendingTaskShow');

    Route::get('/EmployeeProfile', [AdminController::class, 'EmployeeProfile'])->name('EmployeeProfile');
    Route::get('/EmployeeProfileShow', [AdminController::class, 'EmployeeProfileShow'])->name('EmployeeProfileShow');
});


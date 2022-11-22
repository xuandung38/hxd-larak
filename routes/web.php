<?php

use App\Http\Controllers\Admin as AdminCtl;
use App\Http\Controllers\Auth as AutCtl;
use App\Http\Controllers\User as UserCtl;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('index');
});

// Auth
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::group(['prefix' => 'user', 'controller' => AutCtl\UserController::class], function () {
        Route::get('/login', 'showLoginForm')->name('show_user_login_form');
        Route::post('/login', 'login')->name('user_login');
        Route::get('/logout', 'logout')->name('user_logout');
        Route::get('/register', 'showRegisterForm')->name('show_user_register_form');
        Route::post('/register', 'registerUser')->name('register_user');
        Route::get('/verify-email/{token}', 'verifyEmail')->name('verify_user_email');
        Route::get('/forget-password', 'showForgetPasswordForm')->name('show_user_forget_password_form');
        Route::post('/forget-password', 'createResetPasswordToken')->name('create_user_reset_password_token');
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('show_user_reset_password_form');
        Route::post('/reset-password/{token}', 'resetPassword')->name('reset_user_password');
        Route::get('/password', 'password')->name('user_password');
        Route::patch('/change-password', 'changePassword')->name('change_user_password');
    });

    Route::group(['prefix' => 'admin', 'controller' => AutCtl\AdminController::class], function () {
        Route::get('/login', 'showLoginForm')->name('show_admin_login_form');
        Route::post('/login', 'login')->name('admin_login');
        Route::get('/logout', 'logout')->name('admin_logout');
        Route::patch('/change-password', 'changePassword')->name('change_admin_password');
        Route::get('/forget-password', 'showForgetPasswordForm')->name('show_admin_forget_password_form');
        Route::post('/forget-password', 'createResetPasswordToken')->name('create_admin_reset_password_token');
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('show_admin_reset_password_form');
        Route::post('/reset-password/{token}', 'resetPassword')->name('reset_admin_password');
    });
});

Route::group(['middleware' => ['auth:user']], function () {
    Route::group(['controller' => UserCtl\IndexController::class], function () {
        Route::get('/index', 'index')->name('index');
    });
});

// Player area
Route::group(['as' => 'user.', 'middleware' => ['auth:user']], function () {
    //Profile
    Route::group(['controller' => UserCtl\ProfileController::class], function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::patch('/profile', 'updateProfile')->name('update_profile');
        Route::patch('/password', 'updatePassword')->name('update_password');
    });
});

// Admin area
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('/', [App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

    // Profile

    Route::group(['controller' => AdminCtl\ProfileController::class], function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::patch('/profile', 'updateProfile')->name('update_profile');
        Route::patch('/password', 'updatePassword')->name('update_password');
    });
    //User

    Route::group(['controller' => AdminCtl\UserController::class], function () {
        Route::get('/users', 'index')->name('users_index');
        Route::get('/users/export', 'export')->name('users_export');
        Route::post('users', 'store')->name('ajax_create_user');
        Route::patch('users/{user}', 'update')->name('ajax_update_user');
        Route::delete('users/{user}', 'delete')->name('ajax_delete_user');
    });

    // Blog Categories

    Route::group(['controller' => AdminCtl\BlogCategoryController::class], function () {
        Route::get('/blog-categories', 'index')->name('blog_categories_index');
        Route::post('blog-categories', 'store')->name('ajax_create_blog_category');
        Route::patch('blog-categories/{category}', 'update')->name('ajax_update_blog_category');
        Route::delete('blog-categories/{category}', 'delete')->name('ajax_delete_blog_category');
        Route::get('blog-categories/search', 'search')->name('ajax_search_blog_category');
    });

    // Post

    Route::group(['controller' => AdminCtl\PostController::class], function () {
        Route::get('/posts', 'index')->name('posts_index');
        Route::post('posts', 'store')->name('ajax_create_post');
        Route::patch('posts/{post}', 'update')->name('ajax_update_post');
        Route::delete('posts/{post}', 'delete')->name('ajax_delete_post');
        Route::get('posts/search', 'search')->name('ajax_search_post');
    });
});

// System admin area
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin', 'authorize.system_admin']], function () {
    //System
    Route::group(['controller' => AdminCtl\SettingController::class], function () {
        Route::get('/setting', 'index')->name('setting_index');
        Route::patch('setting/{setting}', 'update')->name('ajax_update_setting');
    });

    // Role
    Route::group(['controller' => AdminCtl\RoleController::class], function () {
        Route::get('/roles', 'index')->name('roles_index');
        Route::post('roles', 'store')->name('ajax_create_role');
        Route::patch('roles/{role}', 'update')->name('ajax_update_role');
        Route::delete('roles/{role}', 'delete')->name('ajax_delete_role');
    });

    // Admin
    Route::group(['controller' => AdminCtl\AdminController::class], function () {
        Route::get('/admins', 'index')->name('admins_index');
        Route::post('admins', 'store')->name('ajax_create_admin');
        Route::patch('admins/{admin}', 'update')->name('ajax_update_admin');
        Route::delete('admins/{admin}', 'delete')->name('ajax_delete_admin');
    });
});

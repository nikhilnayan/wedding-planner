<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\GiftRegistryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Wedding routes
Route::middleware(['auth'])->group(function () {
    // Wedding routes
    Route::resource('weddings', WeddingController::class);
    Route::get('/weddings/{wedding}/dashboard', [WeddingController::class, 'dashboard'])->name('weddings.dashboard');
    Route::delete('/weddings/{wedding}', [WeddingController::class, 'destroy'])->name('weddings.destroy');
    
    
    // Guest routes
    Route::get('/weddings/{wedding}/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/weddings/{wedding}/guests/create', [GuestController::class, 'create'])->name('guests.create');
    Route::post('/weddings/{wedding}/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::get('/weddings/{wedding}/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/weddings/{wedding}/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
    Route::delete('/weddings/{wedding}/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('/weddings/{wedding}/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::post('/weddings/{wedding}/guests/import', [GuestController::class, 'processImport'])->name('guests.process-import');
    
    // Vendor routes
    Route::get('/weddings/{wedding}/vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('/weddings/{wedding}/vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('/weddings/{wedding}/vendors', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('/weddings/{wedding}/vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('/weddings/{wedding}/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::put('/weddings/{wedding}/vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update');
    Route::delete('/weddings/{wedding}/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');
    
    // Budget routes
    Route::get('/weddings/{wedding}/budget', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('/weddings/{wedding}/budget/categories/create', [BudgetController::class, 'createCategory'])->name('budget.create-category');
    Route::post('/weddings/{wedding}/budget/categories', [BudgetController::class, 'storeCategory'])->name('budget.store-category');
    Route::get('/weddings/{wedding}/budget/categories/{category}/edit', [BudgetController::class, 'editCategory'])->name('budget.edit-category');
    Route::put('/weddings/{wedding}/budget/categories/{category}', [BudgetController::class, 'updateCategory'])->name('budget.update-category');
    Route::delete('/weddings/{wedding}/budget/categories/{category}', [BudgetController::class, 'destroyCategory'])->name('budget.destroy-category');
    Route::get('/weddings/{wedding}/budget/categories/{category}/items/create', [BudgetController::class, 'createItem'])->name('budget.create-item');
    Route::post('/weddings/{wedding}/budget/categories/{category}/items', [BudgetController::class, 'storeItem'])->name('budget.store-item');
    Route::get('/weddings/{wedding}/budget/categories/{category}/items/{item}/edit', [BudgetController::class, 'editItem'])->name('budget.edit-item');
    Route::put('/weddings/{wedding}/budget/categories/{category}/items/{item}', [BudgetController::class, 'updateItem'])->name('budget.update-item');
    Route::delete('/weddings/{wedding}/budget/categories/{category}/items/{item}', [BudgetController::class, 'destroyItem'])->name('budget.destroy-item');
    
    // Timeline routes
    Route::get('/weddings/{wedding}/timelines', [TimelineController::class, 'index'])->name('timelines.index');
    Route::get('/weddings/{wedding}/timelines/create', [TimelineController::class, 'create'])->name('timelines.create');
    Route::post('/weddings/{wedding}/timelines', [TimelineController::class, 'store'])->name('timelines.store');
    Route::get('/weddings/{wedding}/timelines/{timeline}/edit', [TimelineController::class, 'edit'])->name('timelines.edit');
    Route::put('/weddings/{wedding}/timelines/{timeline}', [TimelineController::class, 'update'])->name('timelines.update');
    Route::delete('/weddings/{wedding}/timelines/{timeline}', [TimelineController::class, 'destroy'])->name('timelines.destroy');
    Route::get('/weddings/{wedding}/timelines/{timeline}/tasks/create', [TimelineController::class, 'createTask'])->name('timelines.create-task');
    Route::post('/weddings/{wedding}/timelines/{timeline}/tasks', [TimelineController::class, 'storeTask'])->name('timelines.store-task');
    Route::get('/weddings/{wedding}/timelines/{timeline}/tasks/{task}/edit', [TimelineController::class, 'editTask'])->name('timelines.edit-task');
    Route::put('/weddings/{wedding}/timelines/{timeline}/tasks/{task}', [TimelineController::class, 'updateTask'])->name('timelines.update-task');
    Route::delete('/weddings/{wedding}/timelines/{timeline}/tasks/{task}', [TimelineController::class, 'destroyTask'])->name('timelines.destroy-task');
    
    // Gift Registry routes
    Route::get('/weddings/{wedding}/gift-registries', [GiftRegistryController::class, 'index'])->name('gift-registries.index');
    Route::get('/weddings/{wedding}/gift-registries/create', [GiftRegistryController::class, 'create'])->name('gift-registries.create');
    Route::post('/weddings/{wedding}/gift-registries', [GiftRegistryController::class, 'store'])->name('gift-registries.store');
    Route::get('/weddings/{wedding}/gift-registries/{registry}/edit', [GiftRegistryController::class, 'edit'])->name('gift-registries.edit');
    Route::put('/weddings/{wedding}/gift-registries/{registry}', [GiftRegistryController::class, 'update'])->name('gift-registries.update');
    Route::delete('/weddings/{wedding}/gift-registries/{registry}', [GiftRegistryController::class, 'destroy'])->name('gift-registries.destroy');
    Route::get('/weddings/{wedding}/gift-registries/{registry}/items/create', [GiftRegistryController::class, 'createItem'])->name('gift-registries.create-item');
    Route::post('/weddings/{wedding}/gift-registries/{registry}/items', [GiftRegistryController::class, 'storeItem'])->name('gift-registries.store-item');
    Route::get('/weddings/{wedding}/gift-registries/{registry}/items/{item}/edit', [GiftRegistryController::class, 'editItem'])->name('gift-registries.edit-item');
    Route::put('/weddings/{wedding}/gift-registries/{registry}/items/{item}', [GiftRegistryController::class, 'updateItem'])->name('gift-registries.update-item');
    Route::delete('/weddings/{wedding}/gift-registries/{registry}/items/{item}', [GiftRegistryController::class, 'destroyItem'])->name('gift-registries.destroy-item');
});


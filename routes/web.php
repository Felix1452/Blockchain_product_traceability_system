<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function(){
    Route::middleware(checkLoginPerrmission::class)->group(function () {
        Route::prefix('admin')->group(function () {

            Route::get('/', [SeedsupplierController::class, 'index'])->name('admin');

            #block
            Route::middleware(CheckLoginPerrmissionAdmin::class)->group(function (){
                Route::prefix('blocks')->group(function () {
                    Route::get('/add', [testBlockChainController::class, 'create'])->name('admin.blocks.add');
                    Route::post('/add', [testBlockChainController::class, 'store']);
                });
            });

            #user
            Route::middleware(CheckLoginPerrmissionAdmin::class)->group(function (){
                Route::prefix('users')->group(function () {
                    Route::get('/add', [UserController::class, 'create'])->name('admin.users.add');
                    Route::post('/add',[UserController::class,'store']);
                    Route::get('/list', [UserController::class, 'index'])->name('admin.users.list');
                    Route::get('/edit/{user}', [UserController::class, 'show']);
                    Route::post('/edit/{user}', [UserController::class, 'update']);
                    Route::get('/editIntern/{user}/{active}', [UserController::class, 'updateIntern']);
                    Route::DELETE('/destroy', [UserController::class, 'destroy']);
                    Route::get('/forgot/{user}', [UserController::class, 'forgotpass'])->name('admin.users.forgotpasss');
                    Route::post('/forgot/{user}', [UserController::class, 'updatePass']);
                });
            });


            #seedsupplier
            Route::prefix('seedsuppliers')->group(function () {
                Route::get('/add', [SeedsupplierController::class, 'create'])->name('admin.seedsuppliers.add');
                Route::post('/add',[SeedsupplierController::class,'store']);
                Route::get('/list', [SeedsupplierController::class, 'index'])->name('admin.seedsuppliers.list');
                Route::get('/edit/{seedsupplier}', [SeedsupplierController::class, 'show']);
                Route::post('/edit/{seedsupplier}', [SeedsupplierController::class, 'update']);
                Route::DELETE('/destroy', [SeedsupplierController::class, 'destroy']);
            });

            #farmer
            Route::prefix('farmers')->group(function () {
                Route::get('/add', [FarmerController::class, 'create'])->name('admin.farmers.add');
                Route::post('/add',[FarmerController::class,'store']);
                Route::get('/list', [FarmerController::class, 'index'])->name('admin.farmers.list');
                Route::get('/edit/{farmer}', [FarmerController::class, 'show']);
                Route::post('/edit/{farmer}', [FarmerController::class, 'update']);
                Route::DELETE('/destroy', [FarmerController::class, 'destroy']);
            });

            #saleroom
            Route::prefix('salerooms')->group(function () {
                Route::get('/add', [SaleroomController::class, 'create'])->name('admin.salerooms.add');
                Route::post('/add',[SaleroomController::class,'store']);
                Route::get('/list', [SaleroomController::class, 'index'])->name('admin.salerooms.list');
                Route::get('/edit/{salesroom}', [SaleroomController::class, 'show']);
                Route::post('/edit/{salesroom}', [SaleroomController::class, 'update']);
                Route::DELETE('/destroy', [SaleroomController::class, 'destroy']);
            });

            #seedsandseedlings
            Route::prefix('seedsandseedlings')->group(function () {
                Route::get('/add', [SeedsandSeedlingsController::class, 'create'])->name('admin.seedsandseedlings.add');
                Route::post('/add',[SeedsandSeedlingsController::class,'store']);
                Route::get('/list', [SeedsandSeedlingsController::class, 'index'])->name('admin.seedsandseedlings.list');
                Route::get('/edit/{seedsandseedling}', [SeedsandSeedlingsController::class, 'show']);
                Route::post('/edit/{seedsandseedling}', [SeedsandSeedlingsController::class, 'update']);
                Route::DELETE('/destroy', [SeedsandSeedlingsController::class, 'destroy']);
            });

            #crops
            Route::prefix('crops')->group(function () {
                Route::get('/add', [CropController::class, 'create'])->name('admin.crops.add');
                Route::post('/add',[CropController::class,'store']);
                Route::get('/list', [CropController::class, 'index'])->name('admin.crops.list');
                Route::get('/edit/{crop}', [CropController::class, 'show']);
                Route::post('/edit/{crop}', [CropController::class, 'update']);
                Route::DELETE('/destroy', [CropController::class, 'destroy']);
            });

            #slider
            Route::prefix('sliders')->group(function () {
                Route::get('add', [SliderController::class, 'create'])->name('admin.sliders.add');
                Route::post('add', [SliderController::class, 'store']);
                Route::get('list', [SliderController::class, 'index'])->name('admin.sliders.list');
                Route::get('edit/{slider}', [SliderController::class, 'show']);
                Route::post('edit/{slider}', [SliderController::class, 'update']);
                Route::DELETE('destroy', [SliderController::class, 'destroy']);
            });

            #products
            Route::prefix('products')->group(function () {
                Route::get('/add', [ProductController::class, 'create'])->name('admin.products.add');
                Route::post('/add',[ProductController::class,'store']);
                Route::get('/list', [ProductController::class, 'index'])->name('admin.products.list');
                Route::get('/edit/{product}', [ProductController::class, 'show']);
                Route::post('/edit/{product}', [ProductController::class, 'update']);
                Route::DELETE('/destroy', [ProductController::class, 'destroy']);

                Route::get('addimg/{product}', [ProductImgController::class, 'createImg']);
                Route::post('addimg/{product}', [ProductImgController::class, 'storeImg']);
                Route::get('imglist', [ProductImgController::class, 'imgList']);
                Route::DELETE('destroyImg', [ProductImgController::class, 'destroyImg']);
            });

            #menu
            Route::prefix('menus')->group(function () {
                Route::get('add', [MenuController::class, 'create']);
                Route::post('add', [MenuController::class, 'store']);
                Route::get('list', [MenuController::class, 'index']);
                Route::get('edit/{menu}', [MenuController::class, 'show']);
                Route::post('edit/{menu}', [MenuController::class, 'update']);
                Route::DELETE('destroy', [MenuController::class, 'destroy']);
            });

            #upload
            Route::post('upload/services', [UploadController::class, 'store']);

            #billreceived
            Route::prefix('billreceiveds')->group(function () {
                Route::get('/backupDBFunc', [BillreceivedController::class, 'createDatabaseBackup']);
                Route::get('/add', [BillreceivedController::class, 'create'])->name('admin.billreceiveds.add');
                Route::post('/add',[BillreceivedController::class,'store']);
                Route::post('/getProductValue',[BillreceivedController::class,'getProductValue']);
                Route::get('/list', [BillreceivedController::class, 'index'])->name('admin.billreceiveds.list');
                Route::get('/edit/{billreceived}', [BillreceivedController::class, 'show']);
                Route::post('/edit/{billreceived}', [BillreceivedController::class, 'update']);
                Route::DELETE('/destroy', [BillreceivedController::class, 'destroy']);
            });

            #accuracys
            Route::prefix('accuracys')->group(function () {
                Route::get('/checkview', [AccuracyController::class, 'index']);
                Route::get('/check', [AccuracyController::class, 'checkData']);
                Route::get('/fix', [AccuracyController::class, 'FixError']);
            });

        });
    });
});

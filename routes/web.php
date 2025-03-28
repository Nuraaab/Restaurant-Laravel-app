<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OfflinePaymentController;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AiapplicationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ComponentpageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleandaccessController;
use App\Http\Controllers\CryptocurrencyController;


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'comingSoon')->name('comingSoon');
});





// Authentication
Route::controller(AuthenticationController::class)->group(function () {
    Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
    Route::get('/signin', 'signin')->name('signin');
    Route::get('/signup', 'signup')->name('signup');
});


//dashboard

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index3')->name('index3');
});


// menu category
Route::prefix('menu')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index')->name('user.menu.category.index');
        Route::post('/category/store', 'store')->name('user.menu.category.store');
        Route::get('/category/{id}/edit', 'edit')->name('user.menu.category.edit');
        Route::post('/category/update', 'update')->name('user.menu.category.update');
        Route::post('/category/delete', 'delete')->name('user.menu.category.delete');
    });
    //orders
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order', 'index')->name('user.menu.order.index');
        Route::post('/order/store', 'store')->name('user.menu.order.store');
        Route::post('/order/delete', 'delete')->name('user.menu.order.delete');
        Route::get('/order/{id}', 'show')->name('user.menu.order.show');
        Route::post('/order/status', 'updateStatus')->name('user.menu.order.status');
    });
});

Route::prefix('menu')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/item', 'index')->name('user.menu.item.index');
        Route::get('/item/create', 'create')->name('user.menu.item.create');
        Route::post('/item/store', 'store')->name('user.menu.item.store');
        Route::get('/item/{id}/edit', 'edit')->name('user.menu.item.edit');
        Route::post('/item/update', 'update')->name('user.menu.item.update');
        Route::post('/item/delete', 'delete')->name('user.menu.item.delete');

        Route::post('/item/feature', 'feature')->name('user.menu.item.feature');
        Route::post('/item/flash-remove', 'flashRemove')->name('user.menu.item.flash.remove');
        Route::post('/item/setFlashSale/{id}', 'setFlashSale')->name('user.menu.item.setFlashSale');

        Route::post('/item/slider', 'slider')->name('user.item.slider');
        Route::post('/item/slider/remove', 'sliderRemove')->name('user.item.slider-remove');
        Route::post('/item/slider/db-remove', 'dbSliderRemove')->name('user.item.db-slider-remove');
    });
});
// Route::resource('category', CategoryController::class);

//products
Route::resource('products', ProductController::class);


//review
Route::resource('review', ReviewController::class);

//coupon
Route::resource('coupon', CouponController::class);

//cart
Route::resource('cart', CartController::class);

//order
Route::resource('order', OrderController::class);

//payment gateway
Route::prefix('paymentgateway')->group(function () {
    // OnlinePaymentController
    Route::resource('online', OnlinePaymentController::class)->names('paymentgateway.online');
    Route::post('online/changestatus/{id}',[OnlinePaymentController::class,'changestatus'])->name('paymentgateway.online.changestatus');

    // OfflinePaymentController
    Route::get('offline',[OfflinePaymentController::class,'index'])->name('paymentgateway.offline.index');
    Route::post('offline/store',[OfflinePaymentController::class,'store'])->name('paymentgateway.offline.store');
    Route::get('offline/{id}/edit',[OfflinePaymentController::class,'edit'])->name('paymentgateway.offline.edit');
    Route::POST('offline/update',[OfflinePaymentController::class,'update'])->name('paymentgateway.offline.update');
    Route::post('delete',[OfflinePaymentController::class,'delete'])->name('paymentgateway.offline.delete');
    Route::post('offline/changestatus/{id}',[OfflinePaymentController::class,'changestatus'])->name('paymentgateway.offline.changestatus');

});


//invoice
Route::resource('invoice', InvoiceController::class);


//users
Route::resource('users', UsersController::class);


//users
Route::resource('customer', CustomerController::class);

//roles
Route::resource('roleandaccess', RoleandaccessController::class);

//settings
Route::controller(SettingsController::class)->group(function () {
    // set Receipt_footer
    Route::put('changereceiptfooter', 'changeReceiptFooter')->name('changeReceiptFooter');
    // set Receipt_header
    Route::put('changereceiptheader', 'changeReceiptHeader')->name('changeReceiptHeader');
    //Receipt_stamp
    Route::put('changereceiptstamp', 'changeReceiptStamp')->name('changeReceiptStamp');

    // Change logo

    Route::put('changelogo', 'changeLogo')->name('changeLogo');

    // Change colors


    Route::put('changecolors', 'changeColors')->name('changeColors');

    Route::put('/updatecurrencies', 'updateCurrencies')->name('updateCurrencies');

    Route::get('/company', 'company')->name('company');
});











































Route::controller(HomeController::class)->group(function () {
    Route::get('calendar', 'calendar')->name('calendar');
    Route::get('chatmessage', 'chatMessage')->name('chatMessage');
    Route::get('chatempty', 'chatempty')->name('chatempty');
    Route::get('email', 'email')->name('email');
    Route::get('error', 'error1')->name('error');
    Route::get('faq', 'faq')->name('faq');
    Route::get('gallery', 'gallery')->name('gallery');
    Route::get('kanban', 'kanban')->name('kanban');
    Route::get('pricing', 'pricing')->name('pricing');
    Route::get('termscondition', 'termsCondition')->name('termsCondition');
    Route::get('widgets', 'widgets')->name('widgets');
    Route::get('chatprofile', 'chatProfile')->name('chatProfile');
    Route::get('veiwdetails', 'veiwDetails')->name('veiwDetails');
    Route::get('blankPage', 'blankPage')->name('blankPage');
    Route::get('comingSoon', 'comingSoon')->name('comingSoon');
    Route::get('maintenance', 'maintenance')->name('maintenance');
    Route::get('starred', 'starred')->name('starred');
    Route::get('testimonials', 'testimonials')->name('testimonials');
});

// aiApplication
Route::prefix('aiapplication')->group(function () {
    Route::controller(AiapplicationController::class)->group(function () {
        Route::get('/codegenerator', 'codeGenerator')->name('codeGenerator');
        Route::get('/codegeneratornew', 'codeGeneratorNew')->name('codeGeneratorNew');
        Route::get('/imagegenerator', 'imageGenerator')->name('imageGenerator');
        Route::get('/textgeneratornew', 'textGeneratorNew')->name('textGeneratorNew');
        Route::get('/textgenerator', 'textGenerator')->name('textGenerator');
        Route::get('/videogenerator', 'videoGenerator')->name('videoGenerator');
        Route::get('/voicegenerator', 'voiceGenerator')->name('voiceGenerator');
    });
});

// Authentication
Route::prefix('authentication')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
        Route::get('/signin', 'signin')->name('signin');
        Route::get('/signup', 'signup')->name('signup');
    });
});

// chart
Route::prefix('chart')->group(function () {
    Route::controller(ChartController::class)->group(function () {
        Route::get('/columnchart', 'columnChart')->name('columnChart');
        Route::get('/linechart', 'lineChart')->name('lineChart');
        Route::get('/piechart', 'pieChart')->name('pieChart');
    });
});

// Componentpage
Route::prefix('componentspage')->group(function () {
    Route::controller(ComponentpageController::class)->group(function () {
        Route::get('/alert', 'alert')->name('alert');
        Route::get('/avatar', 'avatar')->name('avatar');
        Route::get('/badges', 'badges')->name('badges');
        Route::get('/button', 'button')->name('button');
        Route::get('/calendar', 'calendar')->name('calendar');
        Route::get('/card', 'card')->name('card');
        Route::get('/carousel', 'carousel')->name('carousel');
        Route::get('/colors', 'colors')->name('colors');
        Route::get('/dropdown', 'dropdown')->name('dropdown');
        Route::get('/imageupload', 'imageUpload')->name('imageUpload');
        Route::get('/list', 'list')->name('list');
        Route::get('/pagination', 'pagination')->name('pagination');
        Route::get('/progress', 'progress')->name('progress');
        Route::get('/radio', 'radio')->name('radio');
        Route::get('/starrating', 'starRating')->name('starRating');
        Route::get('/switch', 'switch')->name('switch');
        Route::get('/tabs', 'tabs')->name('tabs');
        Route::get('/tags', 'tags')->name('tags');
        Route::get('/tooltip', 'tooltip')->name('tooltip');
        Route::get('/typography', 'typography')->name('typography');
        Route::get('/videos', 'videos')->name('videos');
    });
});

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/index2', 'index2')->name('index2');
        // Route::get('/index3', 'index3')->name('index3');
        Route::get('/index4', 'index4')->name('index4');
        Route::get('/index5', 'index5')->name('index5');
        Route::get('/index6', 'index6')->name('index6');
        Route::get('/index7', 'index7')->name('index7');
        Route::get('/index8', 'index8')->name('index8');
        Route::get('/index9', 'index9')->name('index9');
        Route::get('/index10', 'index10')->name('index10');
        Route::get('/wallet', 'wallet')->name('wallet');
    });
});

// Forms
Route::prefix('forms')->group(function () {
    Route::controller(FormsController::class)->group(function () {
        Route::get('/form-layout', 'formLayout')->name('formLayout');
        Route::get('/form-validation', 'formValidation')->name('formValidation');
        Route::get('/form', 'form')->name('form');
        Route::get('/wizard', 'wizard')->name('wizard');
    });
});

// invoice/invoiceList
Route::prefix('invoice')->group(function () {
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice-add', 'invoiceAdd')->name('invoiceAdd');
        Route::get('/invoice-edit', 'invoiceEdit')->name('invoiceEdit');
        Route::get('/invoice-list', 'invoiceList')->name('invoiceList');
        Route::get('/invoice-preview', 'invoicePreview')->name('invoicePreview');
    });
});

// Settings
Route::prefix('settings')->group(function () {
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/company', 'company')->name('company');
        Route::get('/currencies', 'currencies')->name('currencies');
        Route::get('/language', 'language')->name('language');
        Route::get('/notification', 'notification')->name('notification');
        Route::get('/notification-alert', 'notificationAlert')->name('notificationAlert');
        Route::get('/payment-gateway', 'paymentGateway')->name('paymentGateway');
        Route::get('/theme', 'theme')->name('theme');
    });
});

// Table
Route::prefix('table')->group(function () {
    Route::controller(TableController::class)->group(function () {
        Route::get('/tablebasic', 'tableBasic')->name('tableBasic');
        Route::get('/tabledata', 'tableData')->name('tableData');
    });
});

// Users
Route::prefix('users')->group(function () {
    Route::controller(UsersController::class)->group(function () {
        Route::get('/add-user', 'addUser')->name('addUser');
        Route::get('/users-grid', 'usersGrid')->name('usersGrid');
        Route::get('/users-list', 'usersList')->name('usersList');
        Route::get('/view-profile', 'viewProfile')->name('viewProfile');
        Route::get('/add-customer', 'addUser')->name('addCustomer');
        Route::get('/customer-grid', 'usersGrid')->name('CustomerGridGrid');
        Route::get('/customer-list', 'usersList')->name('CustomerList');
    });
});

// Users
Route::prefix('blog')->group(function () {
    Route::controller(BlogController::class)->group(function () {
        Route::get('/addBlog', 'addBlog')->name('addBlog');
        Route::get('/blog', 'blog')->name('blog');
        Route::get('/blogDetails', 'blogDetails')->name('blogDetails');
    });
});

// Users
Route::prefix('roleandaccess')->group(function () {
    Route::controller(RoleandaccessController::class)->group(function () {
        Route::get('/assignRole', 'assignRole')->name('assignRole');
        Route::get('/roleAaccess', 'roleAaccess')->name('roleAaccess');
    });
});

// Users
Route::prefix('cryptocurrency')->group(function () {
    Route::controller(CryptocurrencyController::class)->group(function () {
        Route::get('/marketplace', 'marketplace')->name('marketplace');
        Route::get('/marketplacedetails', 'marketplaceDetails')->name('marketplaceDetails');
        Route::get('/portfolio', 'portfolio')->name('portfolio');
        Route::get('/wallet', 'wallet')->name('wallet');
    });
});

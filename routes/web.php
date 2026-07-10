<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ContactController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'products' => Product::where('active', true)->orderBy('order')->orderBy('name')->take(3)->get(),
    ]);
});

Route::get('/productos', function () {
    return Inertia::render('Products', [
        'products' => Product::where('active', true)->orderBy('order')->orderBy('name')->get(),
    ]);
});

Route::get('/nosotros/historia', function () {
    return Inertia::render('AboutHistoria');
});

Route::get('/nosotros/prensa', function () {
    return Inertia::render('AboutPrensa');
});

Route::get('/ferias', function () {
    return Inertia::render('Fairs');
});

Route::get('/contacto', function () {
    return Inertia::render('Contact');
});

Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::redirect('/', '/admin/productos');

        Route::resource('productos', ProductController::class)
            ->parameters(['productos' => 'product'])
            ->names('products')
            ->except(['show']);

        Route::get('marca', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('marca', [SettingController::class, 'update'])->name('settings.update');

        Route::get('mensajes', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::patch('mensajes/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.read');
        Route::delete('mensajes/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });
});

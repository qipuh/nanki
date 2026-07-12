<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FairController;
use App\Http\Controllers\Admin\FairImageController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\HomeContentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\ContactController;
use App\Models\Fair;
use App\Models\GalleryImage;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'slides' => Slide::where('active', true)->orderBy('order')->orderBy('id')->get(),
        'products' => Product::where('active', true)->orderBy('order')->orderBy('name')->take(3)->get(),
        'gallery' => GalleryImage::where('active', true)->orderBy('order')->orderBy('id')->get(),
        'content' => HomeContentController::current(),
    ]);
});

Route::get('/productos', function (Request $request) {
    $search = $request->string('q')->trim()->toString();

    return Inertia::render('Products', [
        'products' => Product::where('active', true)
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('tagline', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }))
            ->orderBy('order')->orderBy('name')->get(),
        'search' => $search,
    ]);
})->name('products.index');

Route::get('/nosotros/historia', function () {
    return Inertia::render('AboutHistoria', [
        'content' => HomeContentController::current(),
    ]);
});

Route::get('/nosotros/prensa', function () {
    return Inertia::render('AboutPrensa');
});

Route::get('/ferias', function () {
    return Inertia::render('Fairs', [
        'fairs' => Fair::with('images')->where('active', true)->orderBy('order')->orderBy('id')->get(),
    ]);
});

Route::get('/contacto', function () {
    return Inertia::render('Contact');
});

Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/', [AdminAuthController::class, 'store'])->name('login.store');

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('slides', SlideController::class)->except(['show']);

        Route::get('galeria', [GalleryImageController::class, 'index'])->name('gallery.index');
        Route::post('galeria', [GalleryImageController::class, 'store'])->name('gallery.store');
        Route::patch('galeria/reorder', [GalleryImageController::class, 'reorder'])->name('gallery.reorder');
        Route::patch('galeria/{galleryImage}', [GalleryImageController::class, 'update'])->name('gallery.update');
        Route::delete('galeria/{galleryImage}', [GalleryImageController::class, 'destroy'])->name('gallery.destroy');

        Route::resource('productos', ProductController::class)
            ->parameters(['productos' => 'product'])
            ->names('products')
            ->except(['show']);

        Route::resource('ferias', FairController::class)
            ->parameters(['ferias' => 'fair'])
            ->names('fairs')
            ->except(['show']);

        Route::post('ferias/{fair}/imagenes', [FairImageController::class, 'store'])->name('fairs.images.store');
        Route::patch('ferias/{fair}/imagenes/reorder', [FairImageController::class, 'reorder'])->name('fairs.images.reorder');
        Route::delete('ferias/{fair}/imagenes/{fairImage}', [FairImageController::class, 'destroy'])->name('fairs.images.destroy');

        Route::get('marca', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('marca', [SettingController::class, 'update'])->name('settings.update');

        Route::post('contenido-inicio/texto', [HomeContentController::class, 'updateText'])->name('home-content.text');
        Route::get('contenido-inicio/media', [HomeContentController::class, 'media'])->name('home-content.media');
        Route::post('contenido-inicio/imagen', [HomeContentController::class, 'updateImage'])->name('home-content.image');

        Route::get('mensajes', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::patch('mensajes/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.read');
        Route::delete('mensajes/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });
});

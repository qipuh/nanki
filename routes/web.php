<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/productos', function () {
    return Inertia::render('Products'); // To be created
});

Route::get('/nosotros/historia', function () {
    return Inertia::render('AboutHistoria'); // To be created
});

Route::get('/nosotros/prensa', function () {
    return Inertia::render('AboutPrensa'); // To be created
});

Route::get('/ferias', function () {
    return Inertia::render('Fairs'); // To be created
});

Route::get('/contacto', function () {
    return Inertia::render('Contact'); // To be created
});

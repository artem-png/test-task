<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get(
    '/invoices/{id}',
    '\App\Modules\Invoice\Application\Http\Controllers\InvoiceController@getOne'
);

// Also possible to create one route for status changing (preferable, as it is easier to maintain and expand),
// but in the test task description it is written that exactly 3 endpoints should be available
Route::post(
    '/invoices/{id}/approve',
    '\App\Modules\Invoice\Application\Http\Controllers\InvoiceController@approveInvoice'
);
Route::post(
    '/invoices/{id}/reject',
    '\App\Modules\Invoice\Application\Http\Controllers\InvoiceController@rejectInvoice'
);

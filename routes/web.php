<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', function() {
        $totalProducts     = \App\Models\Product::where('is_active', true)->count();
        $lowStockProducts  = \App\Models\Product::with('unit')->whereColumn('stock', '<=', 'min_stock')->get();
        $lowStockCount     = $lowStockProducts->count();
        $todaySales        = \App\Models\Sale::whereDate('date', today())->sum('grand_total');
        $todayTransactions = \App\Models\Sale::whereDate('date', today())->count();
        $recentSales       = \App\Models\Sale::with('user')->whereDate('date', today())->latest()->limit(5)->get();

        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
        $date          = now()->subDays($i);
        $chartLabels[] = $date->format('d M');
        $chartData[]   = (float) \App\Models\Sale::whereDate('date', $date)->sum('grand_total'); // ← tambah (float)
}

        return view('dashboard', compact(
            'totalProducts', 'lowStockProducts', 'lowStockCount',
            'todaySales', 'todayTransactions', 'recentSales',
            'chartLabels', 'chartData'
        ));
    })->name('dashboard');

    // ===== POS =====
    Route::get('/pos', App\Livewire\Pos\Index::class)->name('pos.index');
    Route::get('/pos/sales', App\Livewire\Pos\Sales::class)->name('pos.sales');

    // ===== INVENTORY =====
    Route::get('/products', App\Livewire\Products\Index::class)->name('products.index');
    Route::get('/products/create', App\Livewire\Products\Create::class)->name('products.create');
    Route::get('/products/{product}/edit', App\Livewire\Products\Edit::class)->name('products.edit');

    Route::get('/categories', App\Livewire\Categories\Index::class)->name('categories.index');
    Route::get('/categories/create', App\Livewire\Categories\Create::class)->name('categories.create');
    Route::get('/categories/{category}/edit', App\Livewire\Categories\Edit::class)->name('categories.edit');

    Route::get('/units', App\Livewire\Units\Index::class)->name('units.index');
    Route::get('/units/create', App\Livewire\Units\Create::class)->name('units.create');
    Route::get('/units/{unit}/edit', App\Livewire\Units\Edit::class)->name('units.edit');

    Route::get('/suppliers', App\Livewire\Suppliers\Index::class)->name('suppliers.index');
    Route::get('/suppliers/create', App\Livewire\Suppliers\Create::class)->name('suppliers.create');
    Route::get('/suppliers/{supplier}/edit', App\Livewire\Suppliers\Edit::class)->name('suppliers.edit');

    Route::get('/purchases', App\Livewire\PurchaseOrders\Index::class)->name('purchases.index');
    Route::get('/purchases/create', App\Livewire\PurchaseOrders\Create::class)->name('purchases.create');
    Route::get('/purchases/{purchaseOrder}', App\Livewire\PurchaseOrders\Show::class)->name('purchases.show');

    // ===== LAPORAN =====
    Route::get('/reports/sales', App\Livewire\Reports\Sales::class)->name('reports.sales');
    Route::get('/reports/stock', App\Livewire\Reports\Stock::class)->name('reports.stock');

    // ===== USERS =====
    Route::get('/users', App\Livewire\Users\Index::class)->name('users.index');
    Route::get('/users/create', App\Livewire\Users\Create::class)->name('users.create');
    Route::get('/users/{user}/edit', App\Livewire\Users\Edit::class)->name('users.edit');

    // ===== EXPORTS =====
    Route::get('/export/sales-excel/{dateFrom}/{dateTo}/{payment?}', [App\Http\Controllers\ExportController::class, 'salesExcel'])->name('export.sales.excel');
    Route::get('/export/sales-pdf/{dateFrom}/{dateTo}/{payment?}',   [App\Http\Controllers\ExportController::class, 'salesPdf'])->name('export.sales.pdf');
    Route::get('/export/stock-excel', [App\Http\Controllers\ExportController::class, 'stockExcel'])->name('export.stock.excel');
    Route::get('/export/stock-pdf',   [App\Http\Controllers\ExportController::class, 'stockPdf'])->name('export.stock.pdf');

    // Stock Opname
    Route::get('/stock-opname', App\Livewire\StockOpname\Index::class)->name('stock-opname.index');
    Route::get('/stock-opname/create', App\Livewire\StockOpname\Create::class)->name('stock-opname.create');

});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
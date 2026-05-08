<?php

use App\Http\Controllers\ExportController;
use App\Livewire\Categories\Create;
use App\Livewire\Categories\Edit;
use App\Livewire\Pos\Index as PosIndex;
use App\Livewire\Pos\Sales as PosSales;
use App\Livewire\Products\Create as ProductCreate;
use App\Livewire\Products\Edit as ProductEdit;
use App\Livewire\Products\Index;
use App\Livewire\PurchaseOrders\Show as PurchaseShow;
use App\Livewire\Reports\Sales;
use App\Livewire\Reports\Stock as ReportStock;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', function () {
        $totalProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::with('unit')->whereColumn('stock', '<=', 'min_stock')->get();
        $lowStockCount = $lowStockProducts->count();
        $todaySales = Sale::whereDate('date', today())->sum('grand_total');
        $todayTransactions = Sale::whereDate('date', today())->count();
        $recentSales = Sale::with('user')->whereDate('date', today())->latest()->limit(5)->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = (float) Sale::whereDate('date', $date)->sum('grand_total');
        }

        return view('dashboard', compact(
            'totalProducts', 'lowStockProducts', 'lowStockCount',
            'todaySales', 'todayTransactions', 'recentSales',
            'chartLabels', 'chartData'
        ));
    })->name('dashboard');

    // ===== READ-ONLY (semua role termasuk guest) =====
    Route::get('/pos/sales', PosSales::class)->name('pos.sales');
    Route::get('/products', Index::class)->name('products.index');
    Route::get('/categories', App\Livewire\Categories\Index::class)->name('categories.index');
    Route::get('/units', App\Livewire\Units\Index::class)->name('units.index');
    Route::get('/suppliers', App\Livewire\Suppliers\Index::class)->name('suppliers.index');
    Route::get('/purchases', App\Livewire\PurchaseOrders\Index::class)->name('purchases.index');
    Route::get('/purchases/{purchaseOrder}', PurchaseShow::class)->name('purchases.show');
    Route::get('/stock-opname', App\Livewire\StockOpname\Index::class)->name('stock-opname.index');
    Route::get('/reports/sales', Sales::class)->name('reports.sales');
    Route::get('/reports/stock', ReportStock::class)->name('reports.stock');

    // ===== WRITE (admin, kasir, gudang — tidak termasuk guest) =====
    Route::middleware(['role:admin,kasir,gudang'])->group(function () {
        // POS
        Route::get('/pos', PosIndex::class)->name('pos.index');

        // Products
        Route::get('/products/create', ProductCreate::class)->name('products.create');
        Route::get('/products/{product}/edit', ProductEdit::class)->name('products.edit');

        // Categories
        Route::get('/categories/create', Create::class)->name('categories.create');
        Route::get('/categories/{category}/edit', Edit::class)->name('categories.edit');

        // Units
        Route::get('/units/create', App\Livewire\Units\Create::class)->name('units.create');
        Route::get('/units/{unit}/edit', App\Livewire\Units\Edit::class)->name('units.edit');

        // Suppliers
        Route::get('/suppliers/create', App\Livewire\Suppliers\Create::class)->name('suppliers.create');
        Route::get('/suppliers/{supplier}/edit', App\Livewire\Suppliers\Edit::class)->name('suppliers.edit');

        // Purchases
        Route::get('/purchases/create', App\Livewire\PurchaseOrders\Create::class)->name('purchases.create');

        // Stock Opname
        Route::get('/stock-opname/create', App\Livewire\StockOpname\Create::class)->name('stock-opname.create');

        // Exports
        Route::get('/export/sales-excel/{dateFrom}/{dateTo}/{payment?}', [ExportController::class, 'salesExcel'])->name('export.sales.excel');
        Route::get('/export/sales-pdf/{dateFrom}/{dateTo}/{payment?}', [ExportController::class, 'salesPdf'])->name('export.sales.pdf');
        Route::get('/export/stock-excel', [ExportController::class, 'stockExcel'])->name('export.stock.excel');
        Route::get('/export/stock-pdf', [ExportController::class, 'stockPdf'])->name('export.stock.pdf');
    });

    // ===== USERS (admin & kasir & gudang & guest bisa lihat, hanya admin bisa create/edit) =====
    Route::middleware(['role:admin,kasir,gudang,guest'])->group(function () {
        Route::get('/users', App\Livewire\Users\Index::class)->name('users.index');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users/create', App\Livewire\Users\Create::class)->name('users.create');
        Route::get('/users/{user}/edit', App\Livewire\Users\Edit::class)->name('users.edit');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';

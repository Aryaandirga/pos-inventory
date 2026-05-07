<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyPokemonSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // CATEGORIES
        // -------------------------------------------------------
        $categories = [
            ['name' => 'Booster Pack',      'description' => 'Pack booster kartu Pokemon acak'],
            ['name' => 'Single Card',        'description' => 'Kartu Pokemon satuan'],
            ['name' => 'Elite Trainer Box',  'description' => 'Box set premium berisi booster + aksesori'],
            ['name' => 'Starter Deck',       'description' => 'Deck siap pakai untuk pemula'],
            ['name' => 'Tin Box',            'description' => 'Kaleng koleksi berisi booster pack'],
            ['name' => 'Aksesori',           'description' => 'Sleeve, binder, playmat, dan aksesori lainnya'],
            ['name' => 'Bundle Set',         'description' => 'Paket bundling hemat'],
        ];

        DB::table('categories')->insert(array_map(fn($c) => array_merge($c, [
            'created_at' => now(), 'updated_at' => now()
        ]), $categories));

        $catIds = DB::table('categories')->pluck('id', 'name');

        // -------------------------------------------------------
        // UNITS
        // -------------------------------------------------------
        $units = [
            ['name' => 'Pieces',  'abbreviation' => 'pcs'],
            ['name' => 'Pack',    'abbreviation' => 'pack'],
            ['name' => 'Box',     'abbreviation' => 'box'],
            ['name' => 'Set',     'abbreviation' => 'set'],
        ];

        DB::table('units')->insert(array_map(fn($u) => array_merge($u, [
            'created_at' => now(), 'updated_at' => now()
        ]), $units));

        $unitIds = DB::table('units')->pluck('id', 'abbreviation');

        // -------------------------------------------------------
        // SUPPLIERS
        // -------------------------------------------------------
        $suppliers = [
            ['name' => 'PT. Pikachu Distribusi',   'phone' => '021-5551001', 'email' => 'order@pikadist.co.id',    'address' => 'Jl. Pallet Town No. 1, Jakarta Pusat'],
            ['name' => 'CV. Pokeball Nusantara',   'phone' => '021-5551002', 'email' => 'sales@pokeballns.co.id', 'address' => 'Jl. Cerulean City No. 25, Bandung'],
            ['name' => 'Toko Grosir Gym Badge',    'phone' => '021-5551003', 'email' => 'info@gymbadge.co.id',    'address' => 'Jl. Viridian Forest No. 7, Surabaya'],
            ['name' => 'Pokemon Card Indonesia',   'phone' => '021-5551004', 'email' => 'halo@pci.co.id',         'address' => 'Jl. Indigo Plateau No. 99, Tangerang'],
            ['name' => 'Legendary Distributor',    'phone' => '021-5551005', 'email' => 'order@legendary.co.id',  'address' => 'Jl. Lavender Town No. 13, Depok'],
        ];

        DB::table('suppliers')->insert(array_map(fn($s) => array_merge($s, [
            'created_at' => now(), 'updated_at' => now()
        ]), $suppliers));

        $supplierIds = DB::table('suppliers')->pluck('id')->toArray();

        // -------------------------------------------------------
        // PRODUCTS (100 produk Pokemon)
        // -------------------------------------------------------
        $products = [
            // Booster Pack
            ['name' => 'Booster Pack Scarlet & Violet',          'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 85000,   'cost' => 65000,  'stock' => 150],
            ['name' => 'Booster Pack Paldea Evolved',            'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 85000,   'cost' => 65000,  'stock' => 120],
            ['name' => 'Booster Pack Obsidian Flames',           'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 90000,   'cost' => 68000,  'stock' => 100],
            ['name' => 'Booster Pack Paradox Rift',              'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 90000,   'cost' => 68000,  'stock' => 130],
            ['name' => 'Booster Pack Temporal Forces',           'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 92000,   'cost' => 70000,  'stock' => 110],
            ['name' => 'Booster Pack Twilight Masquerade',       'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 92000,   'cost' => 70000,  'stock' => 95],
            ['name' => 'Booster Pack Stellar Crown',             'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 95000,   'cost' => 72000,  'stock' => 80],
            ['name' => 'Booster Pack Surging Sparks',            'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 95000,   'cost' => 72000,  'stock' => 90],
            ['name' => 'Booster Pack Prismatic Evolutions',      'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 100000,  'cost' => 75000,  'stock' => 70],
            ['name' => 'Booster Pack Sword & Shield',            'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 75000,   'cost' => 55000,  'stock' => 60],
            ['name' => 'Booster Pack Brilliant Stars',           'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 80000,   'cost' => 60000,  'stock' => 50],
            ['name' => 'Booster Pack Astral Radiance',           'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 80000,   'cost' => 60000,  'stock' => 55],
            ['name' => 'Booster Pack Lost Origin',               'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 82000,   'cost' => 62000,  'stock' => 45],
            ['name' => 'Booster Pack Crown Zenith',              'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 82000,   'cost' => 62000,  'stock' => 40],

            // Single Card
            ['name' => 'Charizard ex SAR Obsidian Flames',       'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 850000,  'cost' => 600000, 'stock' => 15],
            ['name' => 'Pikachu ex Special Art Rare',            'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 450000,  'cost' => 300000, 'stock' => 20],
            ['name' => 'Mewtwo ex Full Art',                     'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 380000,  'cost' => 250000, 'stock' => 18],
            ['name' => 'Iono Full Art Trainer',                  'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 320000,  'cost' => 210000, 'stock' => 25],
            ['name' => 'Lugia VStar',                            'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 290000,  'cost' => 190000, 'stock' => 22],
            ['name' => 'Umbreon VMAX Alt Art',                   'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 1200000, 'cost' => 900000, 'stock' => 8],
            ['name' => 'Rayquaza VMAX Alt Art',                  'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 950000,  'cost' => 700000, 'stock' => 10],
            ['name' => 'Gardevoir ex SAR',                       'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 420000,  'cost' => 280000, 'stock' => 17],
            ['name' => 'Miraidon ex SAR',                        'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 350000,  'cost' => 230000, 'stock' => 20],
            ['name' => 'Koraidon ex SAR',                        'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 340000,  'cost' => 225000, 'stock' => 20],
            ['name' => 'Eevee ex SAR Prismatic',                 'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 750000,  'cost' => 550000, 'stock' => 12],
            ['name' => 'Pikachu VMAX Rainbow Rare',              'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 2500000, 'cost' => 1800000,'stock' => 3],
            ['name' => 'Arceus VStar Rainbow Rare',              'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 550000,  'cost' => 380000, 'stock' => 14],
            ['name' => 'Mew VMAX Alt Art',                       'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 480000,  'cost' => 320000, 'stock' => 16],
            ['name' => 'Blissey V Alt Art',                      'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 380000,  'cost' => 250000, 'stock' => 19],
            ['name' => 'Giratina VStar Alt Art',                 'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 650000,  'cost' => 450000, 'stock' => 11],
            ['name' => 'Terapagos ex SAR',                       'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 500000,  'cost' => 340000, 'stock' => 13],
            ['name' => 'Iron Thorns ex SAR',                     'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 280000,  'cost' => 180000, 'stock' => 22],
            ['name' => 'Walking Wake ex SAR',                    'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 310000,  'cost' => 200000, 'stock' => 20],
            ['name' => 'Fezandipiti ex SAR',                     'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 260000,  'cost' => 170000, 'stock' => 25],
            ['name' => 'Munkidori ex SAR',                       'cat' => 'Single Card', 'unit' => 'pcs', 'price' => 240000,  'cost' => 155000, 'stock' => 23],

            // Elite Trainer Box
            ['name' => 'ETB Scarlet & Violet Base',              'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 750000,  'cost' => 580000, 'stock' => 25],
            ['name' => 'ETB Paldea Evolved',                     'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 750000,  'cost' => 580000, 'stock' => 20],
            ['name' => 'ETB Obsidian Flames',                    'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 780000,  'cost' => 600000, 'stock' => 18],
            ['name' => 'ETB Paradox Rift',                       'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 780000,  'cost' => 600000, 'stock' => 15],
            ['name' => 'ETB Temporal Forces',                    'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 800000,  'cost' => 615000, 'stock' => 12],
            ['name' => 'ETB Twilight Masquerade',                'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 800000,  'cost' => 615000, 'stock' => 10],
            ['name' => 'ETB Stellar Crown',                      'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 820000,  'cost' => 630000, 'stock' => 8],
            ['name' => 'ETB Surging Sparks',                     'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 820000,  'cost' => 630000, 'stock' => 10],
            ['name' => 'ETB Prismatic Evolutions Eevee',         'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 900000,  'cost' => 690000, 'stock' => 6],
            ['name' => 'ETB Brilliant Stars',                    'cat' => 'Elite Trainer Box', 'unit' => 'box', 'price' => 720000,  'cost' => 560000, 'stock' => 14],

            // Starter Deck
            ['name' => 'Starter Deck Koraidon',                  'cat' => 'Starter Deck', 'unit' => 'set', 'price' => 175000,  'cost' => 130000, 'stock' => 30],
            ['name' => 'Starter Deck Miraidon',                  'cat' => 'Starter Deck', 'unit' => 'set', 'price' => 175000,  'cost' => 130000, 'stock' => 30],
            ['name' => 'Starter Deck Charizard',                 'cat' => 'Starter Deck', 'unit' => 'set', 'price' => 185000,  'cost' => 140000, 'stock' => 25],
            ['name' => 'Starter Deck Mewtwo',                    'cat' => 'Starter Deck', 'unit' => 'set', 'price' => 185000,  'cost' => 140000, 'stock' => 25],
            ['name' => 'Starter Deck Pikachu',                   'cat' => 'Starter Deck', 'unit' => 'set', 'price' => 175000,  'cost' => 130000, 'stock' => 35],
            ['name' => 'Starter Deck Eevee Heroes',              'cat' => 'Starter Deck', 'unit' => 'set', 'price' => 180000,  'cost' => 135000, 'stock' => 28],

            // Tin Box
            ['name' => 'Tin Box Charizard ex',                   'cat' => 'Tin Box', 'unit' => 'box', 'price' => 380000,  'cost' => 280000, 'stock' => 20],
            ['name' => 'Tin Box Pikachu ex',                     'cat' => 'Tin Box', 'unit' => 'box', 'price' => 350000,  'cost' => 260000, 'stock' => 22],
            ['name' => 'Tin Box Mewtwo ex',                      'cat' => 'Tin Box', 'unit' => 'box', 'price' => 360000,  'cost' => 265000, 'stock' => 18],
            ['name' => 'Tin Box Eevee Prismatic',                'cat' => 'Tin Box', 'unit' => 'box', 'price' => 400000,  'cost' => 295000, 'stock' => 15],
            ['name' => 'Tin Box Snorlax',                        'cat' => 'Tin Box', 'unit' => 'box', 'price' => 340000,  'cost' => 250000, 'stock' => 20],
            ['name' => 'Tin Box Lucario',                        'cat' => 'Tin Box', 'unit' => 'box', 'price' => 345000,  'cost' => 255000, 'stock' => 18],
            ['name' => 'Tin Box Garchomp',                       'cat' => 'Tin Box', 'unit' => 'box', 'price' => 345000,  'cost' => 255000, 'stock' => 16],

            // Aksesori
            ['name' => 'Sleeve Charizard 65pcs',                 'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 85000,   'cost' => 55000,  'stock' => 50],
            ['name' => 'Sleeve Pikachu 65pcs',                   'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 85000,   'cost' => 55000,  'stock' => 50],
            ['name' => 'Sleeve Eevee 65pcs',                     'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 90000,   'cost' => 58000,  'stock' => 45],
            ['name' => 'Binder 9-Pocket Pokemon 20 halaman',     'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 120000,  'cost' => 80000,  'stock' => 35],
            ['name' => 'Binder 4-Pocket Pokemon',                'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 85000,   'cost' => 55000,  'stock' => 40],
            ['name' => 'Playmat Charizard',                      'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 250000,  'cost' => 170000, 'stock' => 20],
            ['name' => 'Playmat Pikachu',                        'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 230000,  'cost' => 155000, 'stock' => 22],
            ['name' => 'Playmat Eevee',                          'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 240000,  'cost' => 162000, 'stock' => 18],
            ['name' => 'Deck Box Pokemon Ultra Pro',             'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 65000,   'cost' => 42000,  'stock' => 60],
            ['name' => 'Top Loader Card Holder 25pcs',          'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 35000,   'cost' => 22000,  'stock' => 80],
            ['name' => 'Magnetic Card Holder One-Touch',        'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 45000,   'cost' => 28000,  'stock' => 70],
            ['name' => 'Dice Set Pokemon 6pcs',                 'cat' => 'Aksesori', 'unit' => 'set', 'price' => 55000,   'cost' => 35000,  'stock' => 45],
            ['name' => 'Counter Coin Pokemon',                  'cat' => 'Aksesori', 'unit' => 'pcs', 'price' => 25000,   'cost' => 15000,  'stock' => 100],
            ['name' => 'Card Divider Pokemon 10pcs',            'cat' => 'Aksesori', 'unit' => 'set', 'price' => 30000,   'cost' => 18000,  'stock' => 60],

            // Bundle Set
            ['name' => 'Bundle Starter Koraidon + Miraidon',    'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 330000,  'cost' => 245000, 'stock' => 15],
            ['name' => 'Bundle 5 Booster Scarlet Violet',       'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 395000,  'cost' => 295000, 'stock' => 20],
            ['name' => 'Bundle ETB + 3 Booster',                'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 970000,  'cost' => 740000, 'stock' => 10],
            ['name' => 'Bundle Tin + Sleeve + Binder',          'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 520000,  'cost' => 385000, 'stock' => 12],
            ['name' => 'Bundle Single Card Tier S (3 kartu)',   'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 1200000, 'cost' => 900000, 'stock' => 5],
            ['name' => 'Bundle Aksesori Lengkap (Sleeve+Deck+Binder)', 'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 250000,  'cost' => 180000, 'stock' => 18],
            ['name' => 'Bundle 10 Booster Mix Set',             'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 780000,  'cost' => 590000, 'stock' => 8],
            ['name' => 'Gift Set Anniversary Pokemon',          'cat' => 'Bundle Set', 'unit' => 'set', 'price' => 650000,  'cost' => 480000, 'stock' => 10],

            // Extra Booster
            ['name' => 'Booster Pack 151 Mew',                  'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 95000,   'cost' => 72000,  'stock' => 75],
            ['name' => 'Booster Pack Paldean Fates',            'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 98000,   'cost' => 74000,  'stock' => 65],
            ['name' => 'Booster Pack Journey Together',         'cat' => 'Booster Pack', 'unit' => 'pack', 'price' => 100000,  'cost' => 76000,  'stock' => 60],
        ];

        $productIds = [];
        foreach ($products as $p) {
            $sku = 'PKM-' . strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $p['name']), 0, 8)) . '-' . rand(100, 999);
            $id = DB::table('products')->insertGetId([
                'category_id' => $catIds[$p['cat']],
                'unit_id'     => $unitIds[$p['unit']],
                'name'        => $p['name'],
                'sku'         => $sku,
                'price'       => $p['price'],
                'cost_price'  => $p['cost'],
                'stock'       => $p['stock'],
                'min_stock'   => 5,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $productIds[] = ['id' => $id, 'price' => $p['price'], 'cost' => $p['cost'], 'stock' => $p['stock']];
        }

        // -------------------------------------------------------
        // GET USER IDS
        // -------------------------------------------------------
        $adminUser  = DB::table('users')->where('email', 'admin@pos.com')->first();
        $kasirUser  = DB::table('users')->where('email', 'kasir@pos.com')->first();
        $gudangUser = DB::table('users')->where('email', 'gudang@pos.com')->first();

        $kasirIds   = array_filter([$adminUser?->id, $kasirUser?->id], fn($id) => $id !== null);
        $gudangIds  = array_filter([$adminUser?->id, $gudangUser?->id], fn($id) => $id !== null);

        if (empty($kasirIds))  $kasirIds  = [1];
        if (empty($gudangIds)) $gudangIds = [1];

        $kasirIds  = array_values($kasirIds);
        $gudangIds = array_values($gudangIds);

        // -------------------------------------------------------
        // PURCHASE ORDERS (selama 1 tahun, ~50 PO)
        // -------------------------------------------------------
        $startDate = Carbon::now()->subYear();
        $poNumber  = 1;

        for ($i = 0; $i < 50; $i++) {
            $poDate    = $startDate->copy()->addDays(rand(0, 365));
            $supplier  = $supplierIds[array_rand($supplierIds)];
            $userId    = $gudangIds[array_rand($gudangIds)];
            $status    = $poDate->lt(Carbon::now()->subDays(7)) ? 'received' : 'pending';
            $poNo      = 'PO-' . $poDate->format('Ymd') . '-' . str_pad($poNumber++, 4, '0', STR_PAD_LEFT);

            // Pilih 2-5 produk random
            $selectedProducts = array_map(
                fn($k) => $productIds[$k],
                array_rand($productIds, rand(2, 5))
            );

            $total = 0;
            $items = [];
            foreach ($selectedProducts as $prod) {
                $qty      = rand(10, 50);
                $price    = $prod['cost'];
                $subtotal = $qty * $price;
                $total   += $subtotal;
                $items[]  = [
                    'product_id' => $prod['id'],
                    'qty'        => $qty,
                    'price'      => $price,
                    'subtotal'   => $subtotal,
                ];
            }

            $poId = DB::table('purchase_orders')->insertGetId([
                'supplier_id' => $supplier,
                'user_id'     => $userId,
                'po_number'   => $poNo,
                'date'        => $poDate->toDateString(),
                'status'      => $status,
                'total'       => $total,
                'notes'       => null,
                'created_at'  => $poDate,
                'updated_at'  => $poDate,
            ]);

            foreach ($items as $item) {
                DB::table('purchase_items')->insert(array_merge($item, [
                    'purchase_order_id' => $poId,
                    'created_at'        => $poDate,
                    'updated_at'        => $poDate,
                ]));
            }
        }

        // -------------------------------------------------------
        // SALES (selama 1 tahun, ~300 transaksi)
        // -------------------------------------------------------
        $invoiceNumber = 1;
        $paymentMethods = ['cash', 'transfer', 'qris'];

        for ($i = 0; $i < 300; $i++) {
            $saleDate = $startDate->copy()->addDays(rand(0, 365));
            $userId   = $kasirIds[array_rand($kasirIds)];
            $invoiceNo = 'INV-' . $saleDate->format('Ymd') . '-' . str_pad($invoiceNumber++, 5, '0', STR_PAD_LEFT);
            $payment  = $paymentMethods[array_rand($paymentMethods)];

            // Pilih 1-4 produk random
            $numProducts = rand(1, 4);
            $keys = array_rand($productIds, $numProducts);
            if (!is_array($keys)) $keys = [$keys];
            $selectedProducts = array_map(fn($k) => $productIds[$k], $keys);

            $total    = 0;
            $discount = 0;
            $items    = [];

            foreach ($selectedProducts as $prod) {
                $qty      = rand(1, 5);
                $price    = $prod['price'];
                $subtotal = $qty * $price;
                $total   += $subtotal;
                $items[]  = [
                    'product_id' => $prod['id'],
                    'qty'        => $qty,
                    'price'      => $price,
                    'subtotal'   => $subtotal,
                ];
            }

            // Discount random kadang-kadang 0%, 5%, 10%
            $discountPercent = [0, 0, 0, 5, 10][rand(0, 4)];
            $discount        = round($total * $discountPercent / 100);
            $grandTotal      = $total - $discount;

            // Amount paid (round up ke ribuan terdekat)
            $amountPaid = ceil($grandTotal / 1000) * 1000;
            if ($payment === 'transfer' || $payment === 'qris') {
                $amountPaid = $grandTotal; // exact
            }
            $change = $amountPaid - $grandTotal;

            $saleId = DB::table('sales')->insertGetId([
                'user_id'        => $userId,
                'invoice_no'     => $invoiceNo,
                'date'           => $saleDate->toDateString(),
                'total'          => $total,
                'discount'       => $discount,
                'grand_total'    => $grandTotal,
                'payment_method' => $payment,
                'amount_paid'    => $amountPaid,
                'change'         => $change,
                'status'         => 'completed',
                'notes'          => null,
                'created_at'     => $saleDate,
                'updated_at'     => $saleDate,
            ]);

            foreach ($items as $item) {
                DB::table('sale_items')->insert(array_merge($item, [
                    'sale_id'    => $saleId,
                    'created_at' => $saleDate,
                    'updated_at' => $saleDate,
                ]));
            }
        }

        // -------------------------------------------------------
        // STOCK ADJUSTMENTS (~30 entri)
        // -------------------------------------------------------
        $adjustmentTypes = ['in', 'out', 'adjustment'];
        $notes = [
            'in'         => ['Stok masuk dari gudang pusat', 'Retur dari customer', 'Koreksi stok opname'],
            'out'        => ['Barang rusak/cacat', 'Sample untuk display', 'Koreksi kelebihan stok'],
            'adjustment' => ['Hasil stock opname', 'Penyesuaian sistem', 'Koreksi data input'],
        ];

        for ($i = 0; $i < 30; $i++) {
            $adjDate = $startDate->copy()->addDays(rand(0, 365));
            $prod    = $productIds[array_rand($productIds)];
            $type    = $adjustmentTypes[array_rand($adjustmentTypes)];
            $qty     = rand(1, 20);
            $noteArr = $notes[$type];
            $note    = $noteArr[array_rand($noteArr)];

            DB::table('stock_adjustments')->insert([
                'product_id' => $prod['id'],
                'user_id'    => $gudangIds[array_rand($gudangIds)],
                'type'       => $type,
                'qty'        => $qty,
                'notes'      => $note,
                'date'       => $adjDate->toDateString(),
                'created_at' => $adjDate,
                'updated_at' => $adjDate,
            ]);
        }

        $this->command->info('✅ Pokemon dummy data berhasil dibuat!');
        $this->command->info('   📦 Produk     : ' . count($products) . ' produk');
        $this->command->info('   🛒 Purchase   : 50 purchase orders');
        $this->command->info('   💳 Sales      : 300 transaksi (1 tahun)');
        $this->command->info('   📊 Adjustment : 30 stock adjustments');
    }
}
<div>
    @if(session('error'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;color:#DC2626;font-size:13px;font-weight:600;">
        {{ session('error') }}
    </div>
    @endif

    <div style="display:flex;gap:20px;height:calc(100vh - 110px);">

        {{-- ===== KIRI: Produk ===== --}}
        <div style="flex:1;display:flex;flex-direction:column;min-width:0;">

            {{-- Search --}}
            <div style="position:relative;margin-bottom:16px;">
                <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari produk atau scan barcode..."
                       style="width:100%;padding:11px 16px 11px 40px;background:#fff;border:1px solid #E5E7EB;border-radius:10px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;color:#111827;outline:none;transition:border-color 0.15s,box-shadow 0.15s;box-shadow:0 1px 2px rgba(0,0,0,0.04);"
                       onfocus="this.style.borderColor='#6366F1';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                       onblur="this.style.borderColor='#E5E7EB';this.style.boxShadow='0 1px 2px rgba(0,0,0,0.04)'">
            </div>

            {{-- Product Grid --}}
            <div style="flex:1;overflow-y:auto;padding-right:4px;">
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;" class="sm:grid-cols-3 xl:grid-cols-4">
                    @forelse($products as $product)
                    <button type="button"
                            wire:key="prod-{{ $product->id }}"
                            wire:click="addToCart({{ $product->id }})"
                            style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:14px;text-align:left;cursor:pointer;transition:all 0.15s;box-shadow:0 1px 3px rgba(0,0,0,0.04);"
                            onmouseover="this.style.borderColor='#6366F1';this.style.boxShadow='0 4px 12px rgba(99,102,241,0.12)';this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.borderColor='#E5E7EB';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)';this.style.transform='translateY(0)'">

                        {{-- Gambar --}}
                        <div style="width:100%;height:300px;background:#F6F4E8;border-radius:8px;margin-bottom:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                            @if($product->image)
                                <img src="{{ asset('uploads/products/' . $product->image) }}"
                                     style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            @else
                                <svg style="width:28px;height:28px;color:#D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>

                        <p style="font-size:12px;font-weight:700;color:#111827;margin:0 0 4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $product->name }}
                        </p>
                        <p style="font-size:11px;color:#9CA3AF;margin:0 0 6px;font-weight:500;">
                            Stok: {{ $product->stock }} {{ $product->unit->abbreviation }}
                        </p>
                        <p style="font-size:13px;font-weight:800;color:#6366F1;margin:0;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </button>
                    @empty
                    <div style="grid-column:span 4;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 0;text-align:center;">
                        <div style="width:56px;height:56px;background:#F3F4F6;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                            <svg style="width:24px;height:24px;color:#D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <p style="font-size:13px;font-weight:600;color:#9CA3AF;margin:0;">Tidak ada produk ditemukan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== KANAN: Cart ===== --}}
        <div style="width:320px;display:flex;flex-direction:column;background:#fff;border-radius:14px;border:1px solid #E5E7EB;box-shadow:0 1px 3px rgba(0,0,0,0.04);flex-shrink:0;">

            {{-- Cart Header --}}
            <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:28px;height:28px;background:#EEF2FF;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:14px;height:14px;color:#6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#111827;margin:0;">Keranjang</p>
                            <p style="font-size:11px;color:#9CA3AF;margin:0;font-weight:500;">{{ count($cart) }} item</p>
                        </div>
                    </div>
                    @if(!empty($cart))
                    <button wire:click="$set('cart', [])"
                            style="font-size:11px;font-weight:700;color:#EF4444;background:none;border:none;cursor:pointer;padding:4px 8px;border-radius:6px;transition:background 0.12s;"
                            onmouseover="this.style.background='#FEF2F2'"
                            onmouseout="this.style.background='none'">
                        Kosongkan
                    </button>
                    @endif
                </div>
            </div>

            {{-- Cart Items --}}
            <div style="flex:1;overflow-y:auto;padding:12px 16px;display:flex;flex-direction:column;gap:8px;">
                @forelse($cart as $key => $item)
                <div style="background:#F9FAFB;border-radius:10px;padding:10px 12px;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:8px;">
                        <div style="min-width:0;flex:1;">
                            <p style="font-size:12px;font-weight:700;color:#111827;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item['name'] }}</p>
                            <p style="font-size:11px;color:#6366F1;font-weight:600;margin:2px 0 0;">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <button wire:click="removeFromCart('{{ $key }}')"
                                style="width:22px;height:22px;background:#FEF2F2;border:none;border-radius:6px;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;transition:background 0.12s;"
                                onmouseover="this.style.background='#FECACA'"
                                onmouseout="this.style.background='#FEF2F2'">
                            <svg style="width:10px;height:10px;color:#EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <button type="button"
                                    wire:click.prevent="updateQty('{{ $key }}', {{ $item['qty'] - 1 }})"
                                    style="width:26px;height:26px;background:#fff;border:1px solid #E5E7EB;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.12s;"
                                    onmouseover="this.style.borderColor='#6366F1';this.style.color='#6366F1'"
                                    onmouseout="this.style.borderColor='#E5E7EB';this.style.color='inherit'">
                                <svg style="width:12px;height:12px;color:#374151;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                            </button>
                            <span style="font-size:13px;font-weight:700;color:#111827;min-width:20px;text-align:center;">{{ $item['qty'] }}</span>
                            <button type="button"
                                    wire:click.prevent="updateQty('{{ $key }}', {{ $item['qty'] + 1 }})"
                                    style="width:26px;height:26px;background:#fff;border:1px solid #E5E7EB;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.12s;"
                                    onmouseover="this.style.borderColor='#6366F1'"
                                    onmouseout="this.style.borderColor='#E5E7EB'">
                                <svg style="width:12px;height:12px;color:#374151;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                        <p style="font-size:12px;font-weight:700;color:#374151;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:160px;text-align:center;">
                    <div style="width:48px;height:48px;background:#F3F4F6;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <svg style="width:22px;height:22px;color:#D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p style="font-size:13px;font-weight:600;color:#9CA3AF;margin:0;">Keranjang kosong</p>
                    <p style="font-size:11px;color:#D1D5DB;margin-top:4px;">Klik produk untuk menambahkan</p>
                </div>
                @endforelse
            </div>

            {{-- Cart Footer --}}
            <div style="padding:14px 16px;border-top:1px solid #F3F4F6;">

                {{-- Diskon --}}
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;flex-shrink:0;">Diskon</label>
                    <div style="position:relative;flex:1;">
                        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:11px;color:#9CA3AF;font-weight:600;">Rp</span>
                        <input type="number" wire:model.live="discount" min="0"
                               style="width:100%;padding:7px 10px 7px 28px;background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;outline:none;transition:border-color 0.15s;"
                               onfocus="this.style.borderColor='#6366F1'"
                               onblur="this.style.borderColor='#E5E7EB'">
                    </div>
                </div>

                {{-- Summary --}}
                <div style="background:#F9FAFB;border-radius:10px;padding:12px;margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:12px;color:#6B7280;font-weight:500;">Subtotal</span>
                        <span style="font-size:12px;font-weight:600;color:#374151;">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($discount > 0)
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:12px;color:#6B7280;font-weight:500;">Diskon</span>
                        <span style="font-size:12px;font-weight:600;color:#EF4444;">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;border-top:1px solid #E5E7EB;padding-top:8px;margin-top:2px;">
                        <span style="font-size:13px;font-weight:700;color:#111827;">Total</span>
                        <span style="font-size:16px;font-weight:800;color:#6366F1;">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Bayar Button --}}
                <button wire:click="openPayment"
                        style="width:100%;padding:13px;background:{{ empty($cart) ? '#9CA3AF' : '#6366F1' }};color:#fff;font-size:14px;font-weight:700;border:none;border-radius:10px;cursor:{{ empty($cart) ? 'not-allowed' : 'pointer' }};transition:background 0.15s;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px;"
                        {{ empty($cart) ? 'disabled' : '' }}
                        @if(!empty($cart)) onmouseover="this.style.background='#4F46E5'" onmouseout="this.style.background='#6366F1'" @endif>
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    {{-- ===== PAYMENT MODAL ===== --}}
    @if($showPaymentModal)
    <div style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.55);padding:16px;">
        <div style="background:#fff;border-radius:16px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.15);animation:fadeUp 0.2s ease both;">

            {{-- Header --}}
            <div style="padding:20px 24px 16px;border-bottom:1px solid #F3F4F6;">
                <h3 style="font-size:16px;font-weight:800;color:#111827;margin:0;">Proses Pembayaran</h3>
                <p style="font-size:12px;color:#9CA3AF;margin:3px 0 0;font-weight:500;">Lengkapi data pembayaran</p>
            </div>

            <div style="padding:20px 24px;display:flex;flex-direction:column;gap:16px;">

                {{-- Total --}}
                <div style="background:#EEF2FF;border-radius:12px;padding:16px;text-align:center;">
                    <p style="font-size:10px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:1px;margin:0 0 4px;">Total Pembayaran</p>
                    <p style="font-size:28px;font-weight:900;color:#6366F1;margin:0;">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</p>
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <p style="font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 8px;">Metode Pembayaran</p>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                        @foreach(['cash' => ['💵','Cash'], 'transfer' => ['🏦','Transfer'], 'qris' => ['📱','QRIS']] as $method => $info)
                        <button type="button"
                                wire:click="$set('paymentMethod', '{{ $method }}')"
                                style="padding:10px 8px;border-radius:10px;border:2px solid {{ $paymentMethod === $method ? '#6366F1' : '#E5E7EB' }};background:{{ $paymentMethod === $method ? '#EEF2FF' : '#fff' }};color:{{ $paymentMethod === $method ? '#6366F1' : '#6B7280' }};font-size:12px;font-weight:700;cursor:pointer;transition:all 0.15s;font-family:'Plus Jakarta Sans',sans-serif;display:flex;flex-direction:column;align-items:center;gap:3px;">
                            <span style="font-size:18px;">{{ $info[0] }}</span>
                            {{ $info[1] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Jumlah Bayar --}}
                <div>
                    <p style="font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 8px;">Jumlah Bayar</p>
                    <div style="position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:13px;color:#6B7280;font-weight:600;">Rp</span>
                        <input type="number"
                               wire:model.live="amountPaid"
                               style="width:100%;padding:12px 16px 12px 36px;background:#F9FAFB;border:1px solid #E5E7EB;border-radius:10px;font-size:18px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;color:#111827;outline:none;transition:border-color 0.15s;"
                               onfocus="this.style.borderColor='#6366F1';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                               onblur="this.style.borderColor='#E5E7EB';this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Kembalian --}}
                <div style="background:{{ $this->change >= 0 ? '#ECFDF5' : '#FEF2F2' }};border-radius:10px;padding:12px 16px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;font-weight:600;color:#374151;">Kembalian</span>
                    <span style="font-size:20px;font-weight:800;color:{{ $this->change >= 0 ? '#10B981' : '#EF4444' }};">
                        Rp {{ number_format($this->change, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Quick Amount --}}
                @if($paymentMethod === 'cash')
                <div>
                    <p style="font-size:11px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 8px;">Uang Pas</p>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                        @foreach([50000, 100000, 200000] as $amount)
                        <button type="button"
                                wire:click="$set('amountPaid', {{ $amount }})"
                                style="padding:8px;background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;font-size:11px;font-weight:700;color:#374151;cursor:pointer;transition:all 0.12s;font-family:'Plus Jakarta Sans',sans-serif;"
                                onmouseover="this.style.borderColor='#6366F1';this.style.color='#6366F1'"
                                onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#374151'">
                            Rp {{ number_format($amount, 0, ',', '.') }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- Footer --}}
            <div style="padding:16px 24px;border-top:1px solid #F3F4F6;display:flex;gap:10px;">
                <button wire:click="$set('showPaymentModal', false)"
                        style="flex:1;padding:12px;background:#F3F4F6;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#374151;cursor:pointer;transition:background 0.12s;font-family:'Plus Jakarta Sans',sans-serif;"
                        onmouseover="this.style.background='#E5E7EB'"
                        onmouseout="this.style.background='#F3F4F6'">
                    Batal
                </button>
                <button wire:click="processPayment"
                        style="flex:1;padding:12px;background:{{ $this->amountPaid < $this->grandTotal ? '#9CA3AF' : '#10B981' }};border:none;border-radius:10px;font-size:13px;font-weight:700;color:#fff;cursor:{{ $this->amountPaid < $this->grandTotal ? 'not-allowed' : 'pointer' }};transition:background 0.15s;font-family:'Plus Jakarta Sans',sans-serif;"
                        {{ $this->amountPaid < $this->grandTotal ? 'disabled' : '' }}
                        @if($this->amountPaid >= $this->grandTotal) onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10B981'" @endif>
                    <span wire:loading.remove>✅ Konfirmasi Bayar</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== SUCCESS MODAL ===== --}}
    @if($showSuccessModal && $lastSale)
    <div style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.55);padding:16px;">
        <div style="background:#fff;border-radius:16px;width:100%;max-width:360px;box-shadow:0 20px 60px rgba(0,0,0,0.15);animation:fadeUp 0.2s ease both;">

            <div style="padding:28px 24px 20px;text-align:center;border-bottom:1px solid #F3F4F6;">
                <div style="width:56px;height:56px;background:#ECFDF5;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg style="width:28px;height:28px;color:#10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:#111827;margin:0 0 4px;">Transaksi Berhasil!</h3>
                <p style="font-size:11px;color:#9CA3AF;font-family:'DM Mono',monospace;margin:0;">{{ $lastSale->invoice_no }}</p>
            </div>

            <div style="padding:16px 24px;display:flex;flex-direction:column;gap:10px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:13px;color:#6B7280;">Total</span>
                    <span style="font-size:13px;font-weight:600;color:#374151;">Rp {{ number_format($lastSale->grand_total, 0, ',', '.') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:13px;color:#6B7280;">Bayar ({{ strtoupper($lastSale->payment_method) }})</span>
                    <span style="font-size:13px;font-weight:600;color:#374151;">Rp {{ number_format($lastSale->amount_paid, 0, ',', '.') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;background:#ECFDF5;border-radius:10px;padding:12px 14px;margin-top:4px;">
                    <span style="font-size:14px;font-weight:700;color:#065F46;">Kembalian</span>
                    <span style="font-size:18px;font-weight:800;color:#10B981;">Rp {{ number_format($lastSale->change, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="padding:16px 24px;border-top:1px solid #F3F4F6;display:flex;gap:10px;">
                <button wire:click="closeSuccess"
                        style="flex:1;padding:11px;background:#F3F4F6;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#374151;cursor:pointer;transition:background 0.12s;font-family:'Plus Jakarta Sans',sans-serif;"
                        onmouseover="this.style.background='#E5E7EB'"
                        onmouseout="this.style.background='#F3F4F6'">
                    Transaksi Baru
                </button>
                <button wire:click="printReceipt"
                        style="flex:1;padding:11px;background:#6366F1;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#fff;cursor:pointer;transition:background 0.15s;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:6px;"
                        onmouseover="this.style.background='#4F46E5'"
                        onmouseout="this.style.background='#6366F1'">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== PRINT MODAL ===== --}}
    @if($showPrintModal && $lastSale)
    <div style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.55);padding:16px;">
        <div style="background:#fff;border-radius:16px;width:100%;max-width:300px;box-shadow:0 20px 60px rgba(0,0,0,0.15);">

            <div id="receipt" style="padding:20px 22px;">

                {{-- Receipt Header --}}
                <div style="text-align:center;margin-bottom:14px;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366F1,#8B5CF6);border-radius:9px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                        <svg style="width:18px;height:18px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h2 style="font-size:14px;font-weight:800;color:#111827;margin:0;">POKE-ART</h2>
                    <p style="font-size:10px;color:#9CA3AF;margin:2px 0 0;">Management System</p>
                    <div style="border-top:1.5px dashed #E5E7EB;margin:10px 0;padding-top:10px;">
                        <p style="font-size:10px;color:#6366F1;font-family:'DM Mono',monospace;font-weight:500;margin:0;">{{ $lastSale->invoice_no }}</p>
                        <p style="font-size:10px;color:#6B7280;margin:3px 0 0;">{{ \Carbon\Carbon::parse($lastSale->date)->format('d M Y') }} · {{ $lastSale->created_at->format('H:i') }}</p>
                        <p style="font-size:10px;color:#9CA3AF;margin:2px 0 0;">Kasir: {{ auth()->user()->name }}</p>
                    </div>
                </div>

                {{-- Items --}}
                <div style="border-top:1.5px dashed #E5E7EB;padding:10px 0;display:flex;flex-direction:column;gap:7px;">
                    @foreach($lastSale->items as $item)
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#111827;margin:0;">{{ $item->product->name }}</p>
                        <div style="display:flex;justify-content:space-between;margin-top:2px;">
                            <span style="font-size:10px;color:#9CA3AF;">{{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <span style="font-size:10px;font-weight:700;color:#374151;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div style="border-top:1.5px dashed #E5E7EB;padding-top:10px;display:flex;flex-direction:column;gap:5px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">Subtotal</span>
                        <span style="font-size:10px;color:#374151;">Rp {{ number_format($lastSale->total, 0, ',', '.') }}</span>
                    </div>
                    @if($lastSale->discount > 0)
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">Diskon</span>
                        <span style="font-size:10px;color:#EF4444;">- Rp {{ number_format($lastSale->discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;margin-top:4px;padding-top:6px;border-top:1px solid #F3F4F6;">
                        <span style="font-size:12px;font-weight:800;color:#111827;">TOTAL</span>
                        <span style="font-size:12px;font-weight:800;color:#6366F1;">Rp {{ number_format($lastSale->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">{{ strtoupper($lastSale->payment_method) }}</span>
                        <span style="font-size:10px;color:#374151;">Rp {{ number_format($lastSale->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">Kembalian</span>
                        <span style="font-size:10px;font-weight:700;color:#10B981;">Rp {{ number_format($lastSale->change, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div style="border-top:1.5px dashed #E5E7EB;margin-top:10px;padding-top:10px;text-align:center;">
                    <p style="font-size:10px;color:#6B7280;font-weight:600;margin:0;">Terima kasih atas pembelian Anda!</p>
                    <p style="font-size:9px;color:#D1D5DB;margin:4px 0 0;">Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>

            </div>

            {{-- Actions --}}
            <div style="padding:0 20px 18px;display:flex;gap:10px;">
                <button onclick="closePrintModal()"
                        style="flex:1;padding:10px;background:#F3F4F6;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#374151;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;"
                        onmouseover="this.style.background='#E5E7EB'"
                        onmouseout="this.style.background='#F3F4F6'">
                    Tutup
                </button>
                <button onclick="printReceipt()"
                        style="flex:1;padding:10px;background:#6366F1;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#fff;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:6px;"
                        onmouseover="this.style.background='#4F46E5'"
                        onmouseout="this.style.background='#6366F1'">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print
                </button>
            </div>
        </div>
    </div>
    @endif

    <script>
        window.addEventListener('close-print-modal', () => {
            @this.call('closePrint');
        });
    </script>
</div>
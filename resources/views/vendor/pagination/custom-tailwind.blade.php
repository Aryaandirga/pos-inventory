@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between uppercase">
        {{-- Info Singkat (Kiri) --}}
        <div class="hidden sm:block">
            <p class="text-[10px] font-black text-gray-400 tracking-widest">
                Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }}
            </p>
        </div>

        {{-- Tombol Navigasi (Kanan) --}}
        <div class="flex items-center gap-2">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 bg-gray-50 text-gray-300 rounded-xl text-xs font-bold cursor-not-allowed border border-gray-100">
                    Prev
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" class="px-3 py-2 bg-white hover:bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold border border-gray-100 transition-all active:scale-90">
                    Prev
                </button>
            @endif

            {{-- Angka-angka --}}
            <div class="flex items-center gap-1 mx-2">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-2 text-gray-300">...</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center bg-indigo-600 text-white rounded-xl text-xs font-black shadow-lg shadow-indigo-200">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="w-8 h-8 flex items-center justify-center bg-white hover:bg-indigo-50 text-gray-500 hover:text-indigo-600 rounded-xl text-xs font-bold transition-all">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" class="px-3 py-2 bg-white hover:bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold border border-gray-100 transition-all active:scale-90">
                    Next
                </button>
            @else
                <span class="px-3 py-2 bg-gray-50 text-gray-300 rounded-xl text-xs font-bold cursor-not-allowed border border-gray-100">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif
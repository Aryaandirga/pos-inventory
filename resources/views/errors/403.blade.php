@extends('layouts.app', ['title' => 'Akses Ditolak'])

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:60vh;">
    <div style="text-align:center;max-width:420px;">

        {{-- Icon --}}
        <div style="width:80px;height:80px;background:#FEF2F2;border-radius:24px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
            <svg width="40" height="40" fill="none" stroke="#EF4444" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <path d="M12 8v4M12 16h.01"/>
            </svg>
        </div>

        {{-- Title --}}
        <h1 style="font-size:28px;font-weight:900;color:#111827;margin:0 0 8px;">Akses Ditolak</h1>
        <p style="font-size:14px;color:#6B7280;margin:0 0 6px;font-weight:500;">
            Fitur ini hanya dapat dilakukan oleh <span style="color:#6366F1;font-weight:700;">Admin</span>.
        </p>
        <p style="font-size:13px;color:#9CA3AF;margin:0 0 32px;">
            Akun kamu saat ini memiliki role
            <span style="background:#EEF2FF;color:#6366F1;padding:2px 10px;border-radius:20px;font-weight:700;font-size:11px;text-transform:uppercase;">
                {{ auth()->user()->roles->first()?->name ?? 'guest' }}
            </span>
            yang hanya bisa melihat data.
        </p>

        {{-- Info box --}}
        <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:16px;padding:16px 20px;margin-bottom:28px;text-align:left;">
            <p style="font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 10px;">Yang bisa kamu lakukan:</p>
            <div style="display:flex;flex-direction:column;gap:6px;">
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;">
                    <svg width="14" height="14" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Melihat semua data yang tersedia
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;">
                    <svg width="14" height="14" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Melihat laporan penjualan & stok
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#9CA3AF;">
                    <svg width="14" height="14" fill="none" stroke="#EF4444" viewBox="0 0 24 24" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    Menambah / mengubah / menghapus data
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#6366F1;color:#fff;border-radius:12px;font-size:13px;font-weight:700;text-decoration:none;transition:background 0.15s;"
           onmouseover="this.style.background='#4F46E5'" onmouseout="this.style.background='#6366F1'">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>

    </div>
</div>
@endsection

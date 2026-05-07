# Pokemon Inventory - Project Context

## Stack
| Teknologi    | Versi         |
|--------------|---------------|
| Laravel      | 13.6.0        |
| PHP          | 8.5.5         |
| Composer     | 2.9.5         |
| Livewire     | 4.2.4         |
| Tailwind CSS | 4.2.4         |
| Node.js      | 24.14.1       |
| NPM          | 11.11.0       |
| PostgreSQL   | 18.3          |

## Database
- Connection : pgsql
- Host       : 127.0.0.1
- Port       : 5432
- Database   : pokemon_inventory
- Username   : postgres

## Migration Notes
- Urutan migration penting di PostgreSQL
- purchase_orders harus sebelum purchase_items
- sales harus sebelum sale_items

## Fitur yang Sudah Selesai
### POS & Kasir
- [x] Dashboard
- [x] POS / Kasir
- [x] Riwayat Penjualan

### Inventory
- [x] Produk
- [x] Kategori
- [x] Supplier
- [x] Purchase Order
- [x] Satuan

### Laporan
- [x] Laporan Penjualan
- [x] Laporan Stock

## Fitur dalam Pengerjaan
- [ ] Pengguna / User Management

## Rencana Pengembangan
- [ ] E-commerce (Lunar)
- [ ] Real-time Market Price Tracking

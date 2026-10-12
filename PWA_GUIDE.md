# SelfNote PWA — Implementasi Fondasi

## Apa yang sudah tersedia
- Manifest + ikon installable 192/512, mode standalone dan shortcut buat catatan.
- Service worker: halaman offline khusus untuk navigasi tanpa koneksi; caching hanya aset Vite yang di-fingerprint dan ikon/manifest/offline page. Tidak pernah menyimpan HTML catatan, API atau respons form di Cache Storage.
- Quick Capture offline: judul dan isi disimpan lokal di `localStorage`, dapat dibuka di editor `/content/create?offline_draft=...` saat koneksi pulih. **Penyimpanan ke database tetap membutuhkan klik Simpan**.
- Indicator online/offline dan tombol Install App hanya saat browser mengeluarkan event instalasi.

## Instalasi
1. Backup proyek dan database, merge source (jangan timpa `.env` atau folder storage user).
2. `npm install && npm run build`.
3. `php artisan optimize:clear && php artisan serve`.
4. Akses `http://localhost:8000` atau HTTPS. Browser memerlukan secure context untuk service worker.
5. Online: buka aplikasi sekali; aktifkan fitur Offline di DevTools Network, lakukan reload: layar Quick Capture muncul. Simpan draft; pulihkan koneksi, klik tautan draft dan Simpan.
6. Pada aplikasi terpasang, uji menu install sesuai dukungan browser. iOS Safari biasanya memakai Share → Add to Home Screen, bukan `beforeinstallprompt`.

## Batasan penting
- **Offline CRUD catatan dari database BELUM tersedia.** Saat offline, tampilkan Quick Capture; jangan menganggap catatan pada server sudah tersinkron otomatis.
- Tidak ada login sesuai scope. Jangan expose aplikasi ke publik dengan catatan sensitif. LocalStorage bukan penyimpanan terenkripsi dan dapat dihapus oleh browser.
- Perlu test browser nyata, Lighthouse dan test Playwright/end-to-end. Tidak ada jaminan penyimpanan persisten di private/incognito mode.
- Service worker memerlukan HTTPS untuk perangkat mobile (localhost exception). PWA tidak otomatis berarti push notifications atau background sync.
- Fase lanjutan: IndexedDB untuk draft dan attachments, server-side idempotent sync queue, conflict resolution, backup/restore, collections, Tiptap, keyboard command palette.

# SelfNote — upgrade features (12 October 2026)

## Scope
- No login, accounts, or authorization was added, as requested.
- Rich-text actions use the browser Selection/Range API (not deprecated `execCommand`). Supports bold, italic, underline, strike, alignment, ordered/unordered list, links, simple clear formatting, and safe plain-text paste. This is a lightweight editor, not TipTap.
- Incoming HTML content is filtered on create/update, and legacy HTML is filtered when opening the edit screen. Allowed formatting: basic text, headings, paragraphs, lists and HTTPS/HTTP links. Unsafe scripts, event attributes and embedded objects are removed. HTML parsing requires PHP `ext-dom`; without it, content is converted to safe plain text.
- Local browser autosave after 650 ms and manual recovery (NOT server auto-save). Changes saved locally remain on that browser, not synced across devices.
- Add pinned/favorite notes, comma-separated tags, text-file export, and last 30 revisions on update.

## Install / upgrade
1. Back up project and database first, especially `storage/app/public`.
2. Copy source over the existing project but **keep existing `.env` and storage data**.
3. Run `composer install`, `npm install`, `php artisan migrate`, `php artisan storage:link`, `npm run build`.
4. For local development: `php artisan serve` and `npm run dev`.
5. In production, configure `APP_DEBUG=false`, HTTPS, regular backups, and access controls at the network/web-server level when data is private. Without login, the routes are accessible to anyone who can reach the application.
6. Regression test: create/edit, formatting, image upload, searching, view filters, pin/favorite, trash/restore, revision restore, download and mobile layout.

## Verification limits
- PHP source syntax and JavaScript syntax checked successfully in the provided environment.
- Full Laravel test suite and Vite build cannot run here because Composer `vendor/` and npm `node_modules/` are not included and npm registry cannot be reached.
- Server autosave, multi-user synchronization, and in-page full document editor features are *not* implemented.

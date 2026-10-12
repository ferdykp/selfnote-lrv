# SelfNote — UI/UX redesign (source-only)

## Install

This archive contains application source files only. It intentionally excludes `.env`, the SQLite database, uploaded/storage files, `vendor`, `node_modules`, and Git history. **Back up your existing application and database before replacing any files.** Merge this source onto a copy of your original project rather than discarding the runtime data.

1. Copy or overlay the provided source files onto your Laravel project, keeping your own `.env` and data.
2. `composer install`
3. `npm ci`
4. `php artisan storage:link`
5. `php artisan optimize:clear`
6. `npm run dev` for local development; `npm run build` for deployment.
7. `php artisan test` and manually test creating/editing notes, images, search, Trash and restoration.

### Changes

- Responsive 262px sidebar on desktop, overlay navigation on phones; clear navigation and functioning theme control.
- Visual design system: Manrope/DM Sans, ink/off-white with vivid violet accents, improved card/status spacing, empty state, and consistent focus indicators.
- Dashboard with total/draft/completed metrics; revised Indonesian microcopy and filters.
- Keyboard access for note cards, `/` shortcut to focus search; abort stale AJAX requests; responsive 1/2/3-column layouts; reduced-motion accessibility.
- Sanitized HTML preview rendering as plain text (Blade escaped); stricter note field length and sort direction validation; delete image with permanently deleted note.
- Kept existing create/edit rich text editor, routes and database table shape.

### Important limitations and follow-up before public deployment

- **The original web routes have no authentication or note ownership model.** Anyone with access to the application may access all notes. **Do not expose this application on a public internet endpoint until authentication, authorization policies and ownership are implemented and tested.** These are intentionally not silently added because they require an account model and data migration decision.
- Rich-text HTML currently relies on `contenteditable` and legacy `document.execCommand`; migrate to a maintained editor with server-side HTML sanitization before allowing untrusted users or public sharing. Status `published` is a label, *not* an access-control feature.
- Source was statically checked where possible. No authenticated end-to-end/browser run or full regression test has been conducted in this environment. Review all existing app functionality before deploying.
- The original uploaded archive contained an `.env` file and live-ish SQLite database; do not distribute them. Rotate any credentials if that archive has been shared beyond your trusted environment.
- Future candidates: auto-save draft, note pinning, tags, optional favorite, recycle bin retention, multi-device synchronization, secure export, and revision history. These are **not implemented** in this redesign package.

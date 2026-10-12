# SelfNote Studio — V4 UI/UX + Editor Upgrade

This package was built from the user-supplied `selfnote(1).zip` and intentionally excludes `.env`, Git internals, `vendor`, `node_modules`, runtime `storage`, and generated build caches. **Overlay the source files on a backed-up project; don't wipe your existing project directory.** Preserve your updated dependency lockfiles (the versions you audited earlier); do not blindly replace them.

## Implemented
- Design language: warm off-white surface, teal/forest accent, higher contrast, new spacing, responsive 320px–ultrawide layout, refreshed sidebar, notes list, editor, trash and revision cards.
- Create and edit screens share one rich-text toolbar: bold, italic, underline, strike, inline code, headings H1–H3, paragraph, blockquote, unordered/ordered list, left/center/right alignment, link, clear formatting, and cover selection.
- Keyboard: Cmd/Ctrl+B/I/U. Markdown-like inline closing tokens: `**bold**`, `*italic*`, `_italic_`, `~~strikethrough~~`, `` `code` ``. Block prefixes on space: `# `, `## `, `### `, `- `, `* `, `1. `, `> `. Conversion requires normal editor text insertion and a caret in the active editor. These are shortcuts, **not a complete CommonMark parser**.
- Backend sanitizer expanded to retain safe `<code>`, `<pre>` and restricted text-align declarations. No inline scripts, unsafe URLs, or arbitrary CSS are allowed.
- Existing PWA assets, routes, notes, flags, tags, revisions, trash, and local-draft mechanism are preserved.

## Upgrade
1. Back up the entire project, `.env` and database.
2. Merge the changed source files, particularly `resources/`, `app/Support/NoteHtml.php`, `public/manifest.webmanifest` and `resources/views/layouts/`. **Do not overwrite `composer.lock` or `package-lock.json` with older files.**
3. Keep `bootstrap/cache` writable and maintain `storage/` from your actual installation.
4. Run `npm install`, `npm run build`, `php artisan optimize:clear`, `php artisan test`, and `php artisan serve`.
5. Verify create/edit/list/trash/revision/export/PWA and local draft restore with actual browser testing.

## Limitations and recommended QA
- Syntax checks passed for editor JS and PHP sanitizer. Browser-based end-to-end tests and Vite compilation were not run here; source should be validated locally before production.
- The editor is still contenteditable/Selection–Range-based, **not Tiptap**. Formatting across multiple nested blocks, multiline Markdown, and rich HTML paste are intentionally limited. Safe plaintext paste is used to prevent untrusted HTML injection.
- Formatting with no selection displays a hint rather than applying to future typing. Full editor behavior (undo/redo, task checklist, tables, embedded images, slash command menu) warrants a dedicated Tiptap/ProseMirror migration and schema migration rather than pretending these are working.
- The old theme stored under localStorage `theme` continues to work. Existing PWA service worker/cache version may need a manual refresh or unregister/re-register during test to see latest assets.
- No login/auth system has been added, as requested. This is not private on a public URL without network-level protection.

# Phase 2 (Tailwind → SCSS) — Progress Ledger

Plan: docs/superpowers/plans/2026-07-07-phase2-tailwind-to-scss.md
Transition: Tailwind `main.css` + SCSS `theme.css` chạy song song tới cutover (Task 18).
Compile: `npm run build:scss` (Dart Sass).

- Task 0: complete — sass installed, build:scss + theme.css enqueued after main.css, site 200.
- Task 1: complete — foundation (_variables/_mixins/_base/_keyframes/_components) byte-faithful port, review clean.
- Task 2: complete — Footer → BEM + _footer.scss, review clean. Method reference established.

DECISION (deviation from plan): Task 17 (JS refactor) is FOLDED into each section task that has a JS class-toggle coupling, to avoid broken interactivity between conversion and end-of-plan. Header→mobile-menu JS; Ecosystem+linh-vuc-tabs→shared initEcosystemTabs (both markups must adopt .is-active together); News→initNewsPagination. Convention: JS toggles `.is-active`/`.is-hidden`; SCSS defines those states.
CONVENTION: transitions use bare easing (`ease`) as in _components — acceptable per review.

- Task 3: complete — Header → BEM + _header.scss; mobile-menu JS now toggles `is-hidden`; page-shell `min-h-screen`→`.ecs-page` (header+footer wrapper). Self-verified clean (no leftover utils, .ecs-page reproduces shell, JS ok, 200).
  NOTE: main.js lines ~303 (ecosystem panel) & ~332 (news page) still toggle `hidden` — intentional, convert in Task 8/9.
- Task 4/6/7: complete — primitives (ecsges_section_heading/underline_link/see_more → .ecs-heading/.ecs-underline/.ecs-see-more, kept .ecsges-underline anim), section-about → .ecs-about, section-journey → .ecs-journey (photo placement via __photo--1..4). Self-verified: build clean, no leftover utils (only rword/rchar reveal hooks), all pages 200, headings render on home+ve-ecs.
  NOTE: un-converted sections still pass Tailwind strings via heading `$class` arg — OK until their conversion (main.css alive).
- Task 5+10: complete — section-hero → .ecs-hero (kept .ecsges-hero-*/hero-* intro classes), section-branch → .ecs-branch. Self-verified clean, 200.
- Task 8: complete — ecosystem + linh-vuc-tabs → BEM; initEcosystemTabs JS now toggles ONLY .is-active. Both tab UIs first-tab is-active server-side, no leftover utils.
- Task 9: complete — section-news → .ecs-news; initNewsPagination JS now toggles ONLY .is-active. **ALL JS class-toggles now semantic** (grep confirms no util toggles remain in main.js). JS refactor (was Task 17) DONE.
  Remaining markup: ve-ecs (5 files), page-hero, ptbv (team/values/guides), index.php. Then cutover (Task 18).
- Ve-ecs (hero/journey/vision-mission/stats) + page-hero: complete → _ve-ecs.scss (4 blocks) + _page-hero.scss. Self-verified: 5 files lint clean, all ecs-ve-* render on /ve-ecs/, ecs-page-hero on both new pages, no leftover utils.
  STILL REMAINING: ve-ecs-values.php (complex absolute fan), ptbv team/values/guides, index.php. Then cutover.
- ptbv (team/values/guides) + index: complete → _ptbv.scss (3 blocks) + _index.scss. 200, blocks render.
- ve-ecs-values: complete → appended .ecs-ve-values to _ve-ecs.scss (kept per-item inline styles; uses data-aos not .ecsges-pin). GATE PASSED: repo-wide grep = NO Tailwind utilities remain in any markup.
- Task 18 CUTOVER (LIVE, reversible): added reset to _base.scss (Preflight essentials); functions.php now enqueues ONLY theme.css (main.css/Tailwind dropped). All 4 pages 200, reset in bundle, no main.css refs.
  PENDING user visual confirmation, THEN cleanup: delete src/tailwind.css + assets/css/main.css, remove tailwind npm deps + build:css/watch:css scripts, update CLAUDE.md. Tailwind files kept until confirmed (revert = re-add main.css enqueue).
  Compile going forward: `npm run build:scss` / `npm run watch:scss`.
- Cleanup (partial): DELETED src/tailwind.css + assets/css/main.css (user-confirmed). All 4 pages still 200, only theme.css used — confirmed dead. Cutover no longer reversible via re-enqueue (would need to rebuild tailwind.css). 
  STILL PENDING (orphaned Tailwind refs): package.json build:css/watch:css scripts + @tailwindcss/cli/tailwindcss devDeps now point at deleted file; CLAUDE.md still documents Tailwind workflow. Offered to user; awaiting go-ahead.
- Cleanup COMPLETE (user: "dọn nốt"): package.json — removed build:css/watch:css scripts, `npm remove @tailwindcss/cli tailwindcss` (only `sass` devDep left), description updated. CLAUDE.md — Commands + Animation/CSS conventions rewritten for SCSS/BEM. functions.php docblock comment fixed. Final verify: build:scss exit 0, all 4 pages 200, only theme.css enqueued, no source refs to tailwind except historical `// ported from Tailwind` comments in SCSS.

=== PHASE 2 COMPLETE. Theme runs entirely on SCSS (assets/css/theme.css from src/scss/). Compile: npm run build:scss / watch:scss. ===

- Post-cleanup (user request): consolidated 15 component partials → 5 (_layout=footer+header, _primitives=heading+buttons, _landing=hero+about+journey+ecosystem+news+branch+index, _ve-ecs unchanged, _pages=page-hero+linh-vuc+ptbv). Verified: sorted rule-block diff before/after = EMPTY (0 diff) → compiled CSS functionally identical. Added npm scripts: build, dev, start, build:scss:dev (expanded). All pages 200.


# Thanawya Helwa — agent handoff

Saved 2026-09-30. Branch `master` matches `origin/master` at `5476306` (`fix: patch alerts and streamline deploy`). Working tree was clean. Repo: https://github.com/OmarTaherSaad/Thanawya-Helwa

Read this before changing deploy, SEO, or tansik. The short always-on rule is `.cursor/rules/project-handoff.mdc`.

## Product

Public Arabic (RTL) site for Egyptian general-secondary students: coordination cutoffs (حدود التنسيق), university and college directory, college comparison, coordination estimate, quizzes, ministry exams, team posts, and an older ticketing area (TAS).

- Site: thanawyahelwa.org
- Blog: WordPress on blog.thanawyahelwa.org, including the Thanawya Helwa Content Factory plugin. That plugin is not in this repository.
- Audience copy and most Blade strings are Arabic.

## Stack

- PHP `^8.4` (`.php-version` is `8.4`). Laravel `^12.60`.
- Frontend: Laravel Mix 6, Vue 2.7, Bootstrap 5, jQuery. Build with `npm run dev` or `npm run production`. Node 20 in CI.
- MySQL. Scout is installed; local `.env.example` uses `SCOUT_DRIVER=database`. Tests force `SCOUT_DRIVER=collection`.
- Other packages: artesaos/seotools, spatie/laravel-medialibrary, laravel/telescope, laravel/socialite, silviolleite/laravelpwa, renatomarinho/laravel-page-speed, simplesoftwareio/simple-qrcode.
- `composer.json` sets `config.platform-check` to `false` so an old web PHP does not fatal on Composer's platform check. Prefer fixing web PHP. Do not turn the check back on until web and CLI are both 8.4+.

## Layout

| Area | Where |
| --- | --- |
| HTTP | `routes/web.php`, `routes/api.php`, `app/Http/Controllers` |
| Tansik domain | `app/Actions/Tansik/`, `app/Models/Tansik/`, `app/Support/Tansik/`, `app/DataTransferObjects/Tansik/` |
| SEO | `app/Actions/Seo/`, `app/Support/PageSeo.php`, `app/Support/SeoSlug.php`, `app/Http/Middleware/ForceCanonicalHost.php`, `docs/seo-production.md` |
| Views | `resources/views` (Blade). Coordination explorer JS: `resources/js/edges.js` |
| Tests | `tests/Feature/Tansik/`, `tests/Feature/SeoCanonicalHostTest.php`, `tests/Feature/RoadmapModulesTest.php`, `tests/Unit/Support/Tansik/` |
| Deploy | `.github/workflows/main.yml`, `scripts/server-deploy.sh` |

Newer tansik and SEO code uses invokable actions. Older areas (`PagesController`, quizzes, posts, tickets, `MinistryExam`, `Quiz`, `User`) are still classic controllers and root-level models. Match the folder you are editing. Do not do a drive-by rewrite.

Roles: middleware `role:THteam` and `role:admin` (`app/Http/Middleware/CheckRole.php`). `isAdmin()` also passes the team check. Team tools live under `/team`. Admin tools under `/team/admins`. Public entry `/admin` is `AdminEntryController`.

## Coordination (tansik)

Source of truth for eras and percent scales: `app/Support/Tansik/ThanawyaCoordinationSystem.php`.

| Slug | Meaning | % max |
| --- | --- | --- |
| `pre_single_year` | Admission year ≤ 2014 | 410 |
| `single_year_paper` | 2015–2020 | 410 |
| `electronic_bank` | 2021–2024 | 410 |
| `new_curriculum` | 2025+ (320-point exams) | 320 |
| `older_candidates` | «أقدم» files `Limit*O*.htm` | 410 |

`faculty_edges.thanawya_system` stores the slug. Rows with a null system still show in the public grid when `year` falls inside that slug's bounds (`applyCoordinationSystemScope`). «أقدم» matches the slug only, not a year range.

Section codes: `E` = علمي, `A` = أدبي. Default section in queries is `E`.

Import from tansik.digital.gov.eg:

- `php artisan tansik:import-government-coordination-limits`
- If the server cannot reach the ministry host: `php artisan tansik:pull-government-coordination-limits` elsewhere, then import with `--portal-file` and `--limits-dir` (or `TANSIK_DIGITAL_GOV_IMPORT_LIMITS_DIR`).

Parser and catalog: `DigitalGovCoordinationLimitParser`, `DigitalGovCoordinationLimitCatalog`, `DigitalGovCoordinationLimitImporter`.

Public explorer route: `tansik.previous_edges` → `/tansik/previous-years-edges`. Percents in the UI must use `percentMaxTotalsForFrontend()`, which is what `f408c29` fixed.

## SEO

- `APP_URL` must be the chosen public origin (scheme + host, no path). Non-matching `Host` gets a 301 when `SEO_CANONICAL_HOST_REDIRECT=true` (default).
- `docs/production.env.example` sets `APP_URL=https://www.thanawyahelwa.org`. `.env.example` sets the apex `https://thanawyahelwa.org`. Confirm the live value before changing redirects.
- Sitemap: `/sitemap.xml` and `/sitemap-{segment}.xml`. A 500 is often pending migrations (`universities` / `unifac` slug columns) or PageSpeed rewriting XML. PageSpeed skips are in `config/laravel-page-speed.php`.
- `RemoveUnwantedResponseHeaders` strips `X-Powered-By` from the Symfony response. `expose_php=Off` is still a server php.ini change.
- Ads: one AdSense slot path. Flags in `.env.example` (`ADS_ENABLED`, `ADSENSE_*`). Config: `config/ads.php`.

## Deploy

Push to `master` triggers `.github/workflows/main.yml`:

1. `npm ci` and `npm run production` on Node 20.
2. Force-push compiled `public/` onto branch `deploy` (`git add -f public/`).
3. SSH to Hostinger: `cd ~/domains/thanawyahelwa.org/public_html`, `git fetch`, `git reset --hard origin/deploy`, then `scripts/server-deploy.sh`.

Server script order: delete `bootstrap/cache/*.php`, `composer install --no-dev`, `php artisan down`, `optimize:clear` + config/route/view cache, `migrate --force`, `queue:restart`, `php artisan up`. A failing step brings maintenance mode back up.

Concurrency group is `production` and does not cancel an in-progress deploy. Timeout is 15 minutes.

`app/Http/Controllers/DeployController.php` and `POST /api/webhook/githhub` (typo kept) are a legacy HMAC hook that runs `cd ~/thanawyahelwa.org; ./deploy.sh`. That path is not the current release process. Do not "fix" production by calling it.

Hostinger trap: SSH `php -v` can be 8.4+ while the site still runs 8.1 because `public_html/.htaccess` (gitignored, server only) has `AddHandler application/x-httpd-ea-php81`. Laravel 12 needs `ReflectionFunction::isAnonymous()` (PHP 8.2+). Details and the `_php-check.php` curl check are in `README.md`.

After a server `.env` or PHP change, from `public_html`: clear `bootstrap/cache/*.php`, then `optimize:clear`, `config:cache`, `route:cache`, `view:cache`.

## Local checks

```bash
php -v   # must be 8.4+
composer check-platform-reqs
php artisan test
npm run dev
```

PHPUnit (`phpunit.xml`) uses `APP_ENV=testing`, array cache/session, sync queue, Telescope off.

Session errors like "failed to open stream" under `storage/framework/sessions` mean that directory is missing. Create the usual `storage/framework/{cache,sessions,views}` and `bootstrap/cache` trees and make them writable.

## Git

- Default branch: `master`. Remote: `origin` → `OmarTaherSaad/Thanawya-Helwa`.
- Commit only when asked. Commit style in recent history: `fix(tansik): …`, `feat(seo): …`, `chore(deps): …`, `docs: …`.
- `deploy` is overwritten by Actions. Do not treat it as a feature branch.
- Leftover local branches as of this save: `cursor/seo-canonical-host-and-onpage-fixes`, `dependabot-fix-81`. Both are behind `master`.

## Recent history worth knowing

- 2026-09-28 `5476306`: Dependabot patches (commonmark 2.10.3, npm overrides) and the current server deploy script.
- 2026-07-29 `f408c29`: per-system max totals for coordination percentages (410 vs 320).
- 2026-07-29 `a1dd6d4` / `9d1ea2c`: clear bootstrap cache before Composer; document the cPanel PHP handler mismatch.
- 2026-06-06: Laravel 12 (`12af3a3`), canonical host redirect (`6d24b49`).
- 2026-06-04: coordination eras, offline ministry import, directory SEO.

## Open traps

- Compiled assets on `master` can be stale until the Actions job commits them onto `deploy`. Production serves `deploy`, not `master`.
- `docs/production.env.example` and `.env.example` disagree on www vs apex. The live `APP_URL` wins.
- Sitemap 500 after new directory columns means migrate on the server (`php artisan migrate --force` is already in `server-deploy.sh`).
- Meilisearch env vars exist, but the example driver is `database`. Do not assume Meilisearch is running in production.

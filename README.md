# Thanawya Helwa (ثانوية حلوة)

Arabic (RTL) website for Egyptian general-secondary (Thanawya Amma) students: past coordination cutoffs, a university and college directory, college comparison, an unofficial cutoff estimate, quizzes, and past ministry exams.

- Live site: https://thanawyahelwa.org
- Blog: https://blog.thanawyahelwa.org. It runs on WordPress and is **not** in this repo.
- Repo: https://github.com/OmarTaherSaad/Thanawya-Helwa
- AI agents: read [`AGENTS.md`](AGENTS.md). It has the full context map.

## Quick start (about 10 minutes)

1. Check PHP. It must be 8.4 or newer.

   ```bash
   php -v
   ```

2. Install dependencies.

   ```bash
   composer install && npm ci
   ```

3. Create `.env` and an app key. Then set `DB_*` to a local MySQL database.

   ```bash
   cp .env.example .env && php artisan key:generate
   ```

4. Create the tables.

   ```bash
   php artisan migrate
   ```

5. Build assets and serve the site.

   ```bash
   npm run dev && php artisan serve
   ```

To fill the coordination table with real data, run `php artisan tansik:import-government-coordination-limits`. See [Coordination data](#coordination-data).

## Run the tests

```bash
php artisan test
```

You should see 33 passing tests (state on 2026-10-16). Tests use an in-memory setup: array cache and session, sync queue, Scout `collection` driver, Telescope off (`phpunit.xml`).

## Tech stack

| Layer | What |
| --- | --- |
| Backend | Laravel 12, PHP 8.4, MySQL |
| Frontend | Blade views, Vue 2.7, Bootstrap 5, jQuery, built with Laravel Mix 6 (Node 20 in CI) |
| Search | Laravel Scout. The `database` driver is the default. Meilisearch is optional. |
| SEO | artesaos/seotools, our own sitemap and `robots.txt`, canonical-host redirect |
| Other | spatie/laravel-medialibrary (images), Socialite (Facebook login), Telescope, PWA (silviolleite/laravelpwa), laravel-page-speed, AdSense |
| Hosting | Hostinger (cPanel). Deploy runs through GitHub Actions. |

## Features

### Public pages

| Feature | URL | Code |
| --- | --- | --- |
| Home, about, join us, media, contact | `/`, `/about-us`, `/join-us`, `/media/*`, `/contact` | `PagesController` |
| Past coordination cutoffs (حدود التنسيق) | `/tansik/previous-years-edges` | `PagesController@TansikPrevEdges`, `resources/js/edges.js`, `app/Actions/Tansik/Coordination/` |
| Unofficial cutoff estimate | `/tansik/coordination-estimate` | `CoordinationEstimateController`, `PredictCoordinationTrendAction` |
| Geographic distribution and guide pages | `/tansik/geographic-distribution`, `/tansik/tzalom`, `/tansik/stages-information`, … | `PagesController` |
| College directory | `/colleges`, `/colleges/{slug}` | `CollegeController` |
| College comparison | `/colleges/compare` | `CollegeComparisonController` |
| University directory | `/universities`, `/universities/{slug}` | `UniversityController` |
| Search (universities and colleges) | `/search` | `SearchController`, `ScoutDirectorySearchAction` |
| Careers hub (static links) | `/careers` | `CareerController` |
| Quizzes | `/quiz` | `QuizController` |
| Past ministry exams | `/ministryExam` | `MinistryExamController` |
| Sitemap and robots | `/sitemap.xml`, `/sitemap-{static,colleges,universities}.xml`, `/robots.txt` | `app/Actions/Seo/` |

### Team area (sign-in required)

Sign in from `/admin`. That link is not in the public menu.

| Feature | URL | Role |
| --- | --- | --- |
| Team members | `/team/members` | `THteam` |
| Team posts (draft → review → approve) and tags | `/team/posts`, `/team/tags` | Signed-in user, then per policy |
| Manual entry and double-check of cutoffs | `/team/tansik/edges` | `THteam` |
| Create quizzes and ministry exams (public pages, team-only create/edit) | `/quiz/create`, `/ministryExam/create` | `THteam` |
| Admin board: all posts, per-member counts, logs, bulk email | `/team/admins/*` | `admin` |

Roles live in `users.role`. An `admin` passes every `THteam` check too.

### Turned off

- **TAS** ticketing (events, tickets, payments): its routes in `routes/web.php` are commented out. The code and views are still in the repo.
- **Legacy deploy webhook**: `POST /api/webhook/githhub` (the typo is in the real route) still exists, but it calls a script that is gone. Do not use it.

## Coordination data

Cutoff scores live in the `faculty_edges` table. Each row links to one college at one university (`unifac`).

The percentage maximum depends on the exam system:

| System | Admission years | Max score |
| --- | --- | --- |
| `pre_single_year` | 2014 and earlier | 410 |
| `single_year_paper` | 2015–2020 | 410 |
| `electronic_bank` | 2021–2024 | 410 |
| `new_curriculum` | 2025 and later | 320 |
| `older_candidates` («أقدم») | Any | 410 |

Section `E` means علمي (science). Section `A` means أدبي (arts).

The rules live in `app/Support/Tansik/ThanawyaCoordinationSystem.php`. Never hardcode 410.

### Import from the ministry site

```bash
php artisan tansik:import-government-coordination-limits
```

Some servers cannot reach `tansik.digital.gov.eg`. In that case:

1. On a machine that can reach it, run:

   ```bash
   php artisan tansik:pull-government-coordination-limits
   ```

2. Copy the downloaded folder to the server.
3. Run the import with `--portal-file` and `--limits-dir`. You can also set `TANSIK_DIGITAL_GOV_IMPORT_LIMITS_DIR` instead.

Timeout, IPv4, and proxy settings are listed at the bottom of `.env.example`.

## Deploy

Pushing to `master` deploys to production. No other step is needed.

1. GitHub Actions (`.github/workflows/main.yml`) builds the assets with `npm run production`.
2. It force-pushes the code and built `public/` to the `deploy` branch.
3. It connects to the Hostinger server over SSH, resets the server to `origin/deploy`, and runs `scripts/server-deploy.sh`.

The server script runs: composer install → maintenance mode on → rebuild caches → migrate → restart queues → maintenance mode off. If any step fails, the site comes out of maintenance mode anyway.

Production serves the `deploy` branch, not `master`. Never commit to `deploy` by hand.

### Cron

The server cron must run `php artisan schedule:run` every minute. The schedule then:

- runs queued jobs every minute (`queue:work --stop-when-empty`)
- prunes Telescope data once a day

## Configuration

All settings are in `.env.example`, with a comment on each. The ones that matter most:

| Variable | Why it matters |
| --- | --- |
| `APP_URL` | This is the canonical site address. Other hosts get a 301 redirect to it when `SEO_CANONICAL_HOST_REDIRECT=true`. Check the live value before changing it. `docs/production.env.example` uses `www`; `.env.example` uses the apex domain. |
| `SCOUT_DRIVER` | `database` by default. Do not assume Meilisearch is running in production. |
| `ADS_ENABLED`, `ADSENSE_CLIENT`, `ADSENSE_SLOT` | AdSense. One ad slot covers the whole layout. |
| `LARAVEL_PAGE_SPEED_ENABLE` | HTML minifier. It skips the sitemap and robots files on purpose. |
| `TANSIK_DIGITAL_GOV_IMPORT_*` | Settings for the ministry importer. |

SEO production notes are in [`docs/seo-production.md`](docs/seo-production.md).

## Troubleshooting

### Composer says PHP is below 8.4

Composer checks the PHP binary that runs Composer itself. That is not always the one you see in your terminal.

1. Check which PHP that is:

   ```bash
   which php && php -v && head -1 "$(command -v composer)" && composer check-platform-reqs
   ```

2. If it shows 8.1 or older, call Composer with the right PHP:

   ```bash
   php8.4 "$(command -v composer)" install
   ```

3. Non-interactive SSH, cron, CI, and IDEs (Cursor, PhpStorm) can use a different `PATH`. That can pick up `/usr/bin/php`. Point each of them at the full path of the 8.4 binary. Examples: Herd at `~/Library/Application Support/Herd/bin/php`, Homebrew at `/opt/homebrew/opt/php@8.4/bin/php`.
4. On Debian or Ubuntu, use `update-alternatives` or a `php8.4` wrapper.

`composer.json` sets `config.platform-check` to `false` on purpose, so an outdated web PHP does not crash on Composer's own check. Turn it back on only when web PHP and CLI PHP are both 8.4 or newer.

### The site errors with `ReflectionFunction::isAnonymous()`, but SSH shows PHP 8.4

The web server runs an older PHP than the command line does. On Hostinger and cPanel, the root `public_html/.htaccess` (gitignored, server only) often pins the PHP version:

```apache
# php -- BEGIN cPanel-generated handler, do not edit
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php81 .php .php8 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit
```

To fix it, do one of these:

- Change `ea-php81` to `ea-php84`.
- Delete the whole block, then pick PHP 8.4 in hPanel → PHP Configuration.

Confirm the web PHP version with a temporary file:

```bash
echo '<?php echo PHP_VERSION;' > public/_php-check.php
curl -s https://thanawyahelwa.org/_php-check.php
rm public/_php-check.php
```

Then rebuild the caches. Run this in `public_html`:

```bash
rm -f bootstrap/cache/*.php && composer dump-autoload -o && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### `/sitemap.xml` returns a 500 error

Migrations are usually still pending. Run `php artisan migrate --force`. Also check that the PageSpeed skips in `config/laravel-page-speed.php` are still there.

### Session error "failed to open stream"

Folders are missing. Create `storage/framework/{cache,sessions,views}` and `bootstrap/cache`, and make them writable.

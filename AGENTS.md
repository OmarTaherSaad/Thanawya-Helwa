# Thanawya Helwa — AI agent context

Last full scan: 2026-10-16 on `master` `eca715d`. Tests: 33 passing (`php artisan test`, PHP 8.4.25).
Humans start at `README.md`. The always-on short rule is `.cursor/rules/project-handoff.mdc` (mirrored in `CLAUDE.md`).
Repo: https://github.com/OmarTaherSaad/Thanawya-Helwa. Single Laravel app. No mobile or desktop app in this repo.

## Hard rules

1. PHP 8.4+ for Composer, Artisan, and web. Never run `composer` or `artisan` on 8.1.
2. Never hardcode 410. Use `ThanawyaCoordinationSystem::percentMaxTotalForSystem()` / `percentMaxTotalsForFrontend()`.
3. Deploy = push `master`. Do not use `DeployController` or touch the `deploy` branch.
4. Do not change `APP_URL` / canonical host without checking production `.env`.
5. Do not commit `.env`, secrets, or anything unless asked.
6. Match the style of the folder being edited (actions in new code, classic controllers in old). No drive-by rewrites.
7. Blog (WordPress, Content Factory plugin) is not in this repo.

## Product

Public Arabic RTL site for Egyptian Thanawya Amma students. UI strings are Arabic, mostly inline in Blade. `lang/ar`, `lang/en` hold only framework strings.

## Stack

| Item | Value |
| --- | --- |
| PHP / Laravel | `^8.4` (`.php-version` = 8.4) / `^12.60`. Old-style app skeleton: `app/Http/Kernel.php`, `app/Console/Kernel.php`, `RouteServiceProvider` with string `Controller@method` routes. |
| Models | Root namespace for old ones: `App\User`, `App\Quiz`, `App\MinistryExam`, `App\MyCodes`. Newer under `App\Models\{Tansik,Team,Ticketing}`. |
| DB | MySQL. 43 migrations (2019–2026). Factories for all main models. |
| Frontend | Mix 6 (`webpack.mix.js`), Vue 2.7, Bootstrap 5, jQuery, axios. Node 20 in CI. Entry points: `app.js`, `home.js`, `edges.js`, `forms.js`, `members.js`, `post.js`, `email-sender.js`, `notifications.js`, `quizzes/*.js`. CKEditor copied from `resources/ckeditor` → `public/texteditor`. |
| Search | Scout. `.env.example` driver `database`; tests `collection`. Meilisearch client installed, not assumed live. Searchable: `University`, `UniFac` (active only). |
| Packages | artesaos/seotools, spatie/laravel-medialibrary 11 (custom path: `MediaLibraryCustomPathGenerator`), socialite (Facebook), telescope (gate list empty → no access outside local), laravelpwa, laravel-page-speed, simple-qrcode, rap2hpoutre/laravel-log-viewer, pusher/echo. |
| Composer | `config.platform-check: false` on purpose. Keep until web PHP is confirmed 8.4+. |

## Directory map

| Area | Path |
| --- | --- |
| Routes | `routes/web.php` (all real routes), `routes/api.php` (legacy webhook only), `routes/console.php` |
| Tansik actions | `app/Actions/Tansik/{College,University,Comparison,Coordination,Prediction}/` |
| Tansik support | `app/Support/Tansik/` — `ThanawyaCoordinationSystem`, `DigitalGovCoordinationLimit{Parser,Catalog,Importer}` |
| DTOs | `app/DataTransferObjects/Tansik/` — `CoordinationTableRequestData` (accepts nested legacy `params` array), `CollegeShowPageData`, `UniversityShowPageData` |
| SEO | `app/Actions/Seo/BuildSitemap*Action.php`, `app/Support/PageSeo.php` (`apply`, `applyNoindex`, `applyNoindexFollow`), `app/Support/SeoSlug.php`, `config/seo.php` |
| Search | `app/Actions/Search/ScoutDirectorySearchAction.php` |
| Commands | `app/Console/Commands/{Import,Pull}TansikDigitalGovernmentCoordinationLimitsCommand.php` |
| Middleware | `CheckRole`, `ForceCanonicalHost`, `RemoveUnwantedResponseHeaders`, `ensureUserHasMobile` (TAS), `LowerCaseRoutes` (disabled) |
| Policies | `app/Policies/` — Member, MinistryExam, Payment, Post, Quiz, Tag, Ticket, User |
| Config (app-specific) | `config/{ads,seo,team,enums,ministryExams,laravel-page-speed}.php` |
| Views | `resources/views/{tansik,colleges,universities,careers,search,quizzes,ministry-exams,posts,members,tags,tansik-work,admins,tas,payments,partials,layouts}` |
| Tests | `tests/Feature/Tansik/{College,University}DirectoryTest.php`, `HistoricalCoordinationTest.php`, `tests/Feature/{SeoCanonicalHostTest,RoadmapModulesTest}.php`, `tests/Unit/Support/Tansik/ThanawyaCoordinationSystemTest.php`, `tests/Unit/Tansik/DigitalGovCoordinationLimitParserTest.php` |
| Deploy | `.github/workflows/main.yml`, `scripts/server-deploy.sh` |
| Docs | `README.md` (human), `AGENTS.md` (this), `docs/seo-production.md`, `docs/production.env.example` |

## Data model

| Table | Model | Notes |
| --- | --- | --- |
| `governorates` | `Tansik\Governorate` | has many `administrations` |
| `administrations` | `Tansik\Administration` | educational district; `getDist()` returns geo group label (أ/ب/ج) |
| `GeoDist` | `Tansik\UniAdmin` (pivot) | `group`, `university_id`, `administration_id` — geographic distribution |
| `universities` | `Tansik\University` | `type` ∈ `config/enums.php` (GOV, PRIVATE, ACD, HI); `slug`, `meta_description`, `is_active`; route key `slug`, legacy numeric id redirects |
| `faculties` | `Tansik\Faculty` | `name`, `common_name`, `sections_allowed` |
| `unifac` | `Tansik\UniFac` (pivot model) | one college at one university. Public "college". `slug`, `address`, `meta_description`, `is_active`. Route key `slug`. |
| `faculty_edges` | `Tansik\FacultyEdge` | cutoff rows: `unifac_id`, `section` (E/A), `year`, `thanawya_system`, `edge` (float), `TempName`, `edit_by`, `confirmed`/`confirmed_by`, `confirmed2`/`confirmed2_by`. Save/delete clears `GetCoordinationDistinctYearsAction` cache. |
| `coordination_prediction_runs` | `Tansik\CoordinationPredictionRun` | log of every estimate request (college, section, method, estimate, payload, ip, user) |
| `users` | `App\User` | `role` ∈ `THteam`, `admin` (also legacy `Ebda3team`, lang reviewer); `mobile_number`, `year`, socialite `provider`/`provider_id` |
| `members` | `Team\Member` (extends User, HasMedia) | team profile; `status` csv |
| `posts`, `tags`, `posts_tags` | `Team\Post`, `Team\Tag` | status enum in `config/team.php`: DRAFT 0, DISMISSED 1, UNDER_REVIEW 2, APPROVED 3, POSTED 4, SCHEDULED 5, DRAFTED_ON_PAGE 6. Writer, cowriter, approver. Soft deletes. |
| `quizzes` | `App\Quiz` | maker, revisor, inserter (members) |
| `ministry_exams` | `App\MinistryExam` | file download; subject codes in `config/ministryExams.php` |
| `tickets`, `payments` | `Ticketing\*` | TAS — dormant |
| `media`, `notifications`, `jobs`, `failed_jobs`, `password_resets` | framework/package | |

## Coordination (tansik) domain

Source of truth: `app/Support/Tansik/ThanawyaCoordinationSystem.php`.

| Slug | Admission year | % max |
| --- | --- | --- |
| `pre_single_year` | ≤ 2014 | 410 |
| `single_year_paper` | 2015–2020 | 410 |
| `electronic_bank` | 2021–2024 | 410 |
| `new_curriculum` | 2025+ | 320 |
| `older_candidates` («أقدم», files `Limit*O*.htm`) | any | 410 |

- Section `E` = علمي, `A` = أدبي. Default `E`.
- `applyCoordinationSystemScope`: rows with null `thanawya_system` still match when `year` is inside the slug's bounds. «أقدم» matches by slug only.
- Public explorer `/tansik/previous-years-edges` (`tansik.previous_edges`) → `resources/js/edges.js` posts to `tansik.get_edges` and `tansik.coordination_table_fields`. Missing system → 422.
- Estimate `/tansik/coordination-estimate`: `PredictCoordinationTrendAction` ignores `older_candidates`; methods `none` → `single_year` → `linear_regression_next_year`, with `avg_last_n_fallback` (last 3) when regression degenerates or projects outside 0–1000. Page is `noindex,follow`. Every run is logged.
- Import: `php artisan tansik:import-government-coordination-limits`. Blocked host: `tansik:pull-government-coordination-limits` elsewhere, then import with `--portal-file` and `--limits-dir` (or `TANSIK_DIGITAL_GOV_IMPORT_LIMITS_DIR`). HTTP knobs: `TANSIK_DIGITAL_GOV_IMPORT_{HTTP_TIMEOUT,HTTP_CONNECT_TIMEOUT,FORCE_IPV4,HTTP_PROXY}`.
- Manual team entry `/team/tansik/edges` (`TansikController`): member edits → a *different* member confirms (`confirmed`) → a third check (`confirmed2`). Picks are random with `lockForUpdate`. Admin counts at `/team/admins/edges`.

## Auth and roles

- `Auth::routes()` + Facebook Socialite (`/auth/{provider}`, `/callback/{provider}`).
- `role:X` middleware (`CheckRole`): passes if `hasRole(X)` or `isAdmin()`. `isTeamMember()` = THteam or admin.
- `/admin` → `AdminEntryController` (guest → login). Not in public nav.
- Team tools under `/team`, admin under `/team/admins` (posts, edge counts, log viewer, bulk email sender).
- Quiz and MinistryExam create = team member; update = owner member (policies).

## SEO

- Global middleware order: `RemoveUnwantedResponseHeaders` → maintenance → … → `TrustProxies` → `ForceCanonicalHost` → CORS → PageSpeed (InlineCss, ElideAttributes, DNSPrefetch, RemoveComments, TrimUrls, RemoveQuotes).
- `ForceCanonicalHost` 301s Host ≠ `APP_URL` host when `SEO_CANONICAL_HOST_REDIRECT=true`. `.env.example` = apex, `docs/production.env.example` = `www`. Live value wins.
- Sitemaps: `/sitemap.xml` index + `sitemap-{static,colleges,universities}.xml`. 500 usually = pending migrations or PageSpeed touching XML (skips in `config/laravel-page-speed.php`).
- Slugs: Arabic-title slugs via `SeoSlug`; legacy numeric-id URLs redirect to canonical slug (tested).
- Ads: `config/ads.php`, one AdSense slot (`ADSENSE_SLOT`), off unless `ADS_ENABLED=true`. Partial `partials/adsense-slots.blade.php`.

## Deploy and ops

1. Push `master` → `.github/workflows/main.yml` (concurrency `production`, no cancel).
2. Build job: Node 20, `npm ci`, `npm run production`, `git checkout -B deploy`, `git add -f public/`, force-push `deploy`.
3. Server job (appleboy/ssh-action, 15 min): `cd ~/domains/thanawyahelwa.org/public_html`, `git reset --hard origin/deploy`, `scripts/server-deploy.sh`.
4. Script: rm `bootstrap/cache/*.php` → `composer install --no-dev` → `artisan down` → `optimize:clear` + config/route/view cache → `migrate --force` → `queue:restart` → `up`. Trap always brings site up.

- Secrets: `SSH_HOST`, `SSH_USERNAME`, `SSH_PRIVATE_KEY`, `SSH_PORT` (GitHub environment `production`).
- Scheduler (`app/Console/Kernel.php`): `queue:work --stop-when-empty` every minute, `telescope:prune` daily. Needs server cron `schedule:run` (server-side, gitignored `run-schedule.sh`).
- Hostinger trap: SSH PHP 8.4 but web 8.1 via cPanel `AddHandler application/x-httpd-ea-php81` in server-only `public_html/.htaccess`. Symptom: `ReflectionFunction::isAnonymous()` undefined. Fix + verify steps in `README.md` → Troubleshooting.
- After server `.env`/PHP change: `rm -f bootstrap/cache/*.php && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache`.

## Local dev and tests

```bash
php -v                      # 8.4+
composer install && npm ci
cp .env.example .env && php artisan key:generate
php artisan migrate
npm run dev
php artisan test            # 33 tests
```

`phpunit.xml`: `APP_ENV=testing`, array cache/session, sync queue, Telescope off, Scout `collection`. Missing `storage/framework/{cache,sessions,views}` → "failed to open stream".

## Git

- Default `master`, remote `origin`. Commit style: `fix(tansik): …`, `feat(seo): …`, `chore(deps): …`, `docs: …`.
- `deploy` is CI-owned. `origin/TAS` holds the old ticketing work.
- Stale branches: local `cursor/seo-canonical-host-and-onpage-fixes`, `dependabot-fix-81`; remote `dependabot/composer/*`, `fix/security-vulnerabilities-dependabot`.

## History

| Date | Commit | What |
| --- | --- | --- |
| 2026-10 | `eca715d` | Require PHP 8.4 |
| 2026-09-28 | `5476306` | Dependabot patches, current server deploy script |
| 2026-07-29 | `f408c29` | Per-system % max (410 vs 320) |
| 2026-07-29 | `a1dd6d4`, `9d1ea2c` | Clear bootstrap cache before Composer; cPanel handler doc |
| 2026-06-06 | `12af3a3`, `6d24b49` | Laravel 12; canonical host redirect |
| 2026-06-04/05 | — | Coordination eras, offline import, directory SEO + slugs, prediction runs |

## Known traps and dead code

- Production serves `deploy`, not `master`. Compiled assets on `master` may be stale.
- `DeployController` + `POST /api/webhook/githhub` (typo is real) → calls dead `~/thanawyahelwa.org/deploy.sh`. Do not use.
- TAS routes commented out in `routes/web.php`; controllers in `app/Http/Controllers/Ticketing/`, views `tas/`, `payments/`, JS `ticketsScan.js`, `payment.js`, `tas-schedule.js`, `scheduleMaker.js`, `herman.js` not built by Mix (`mix()` calls for them would fail).
- `resources/views/tansik/previous-edges.blade copy.php` is a stray copy. `Composer Command.txt` references `ea-php72` and is obsolete.
- `HomeController` and `components/ExampleComponent.vue` have no references.
- `team/tags` and `team/posts` resources are not wrapped in `role:THteam`; access relies on policies.
- Telescope gate email list is empty.
- Meilisearch env exists; production driver unknown — check before relying on it.

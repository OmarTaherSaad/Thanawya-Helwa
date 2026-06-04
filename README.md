# TH-v2

## Requirements

- PHP **8.2+**
- Composer 2.x
- Node.js 18+ (for Laravel Mix assets)

This repo includes a `.php-version` file for **asdf** / **phpenv** so the project shell uses PHP 8.2.

## Composer says PHP is below 8.2

Message: *“Composer detected issues in your platform: Your Composer dependencies require a PHP version \">= 8.2.0\".”*

That compares the **PHP binary that actually runs Composer** to `composer.json`, not whatever you see in another context.

1. **Use the same binary Composer uses**

   ```bash
   which php
   php -v
   head -1 "$(command -v composer)"   # often #!/usr/bin/env php
   php -r "echo PHP_VERSION, PHP_EOL;"
   composer check-platform-reqs
   ```

   If `php -v` is **8.1 or older** here, fix PATH or call Composer explicitly:

   ```bash
   php8.2 "$(command -v composer)" install
   ```

2. **SSH interactive vs deploy / IDE** — Login shells often load `.bashrc` / Homebrew / Herd and point `php` to 8.2; **non-interactive SSH**, **cron**, **CI**, or **Cursor/PhpStorm** may use a different `PATH` and pick `/usr/bin/php` (older). Point those environments at the same PHP 8.2 binary (full path), or set `PATH` before `composer`.

3. **Cursor / VS Code** — Set the workspace / user **PHP executable** to your 8.2 binary (e.g. Herd: `~/Library/Application Support/Herd/bin/php`, Homebrew: `/opt/homebrew/opt/php@8.2/bin/php`).

4. **Debian/Ubuntu** — Prefer `update-alternatives` or a `php8.2` wrapper so `/usr/bin/env php` resolves to 8.2 for the user that runs Composer.

## Website shows the error but SSH `php -v` is 8.2

Composer 2 adds **`vendor/composer/platform_check.php`**, which runs whenever **`vendor/autoload.php`** loads (HTTP requests, `php artisan`, etc.). It uses the **PHP version of that process**, not your SSH CLI binary.

On shared hosting, **CLI** and **FPM / LiteSpeed / Apache module** can differ:

1. In **Hostinger hPanel** → your domain → **PHP configuration** / **Advanced** → set the site to **PHP 8.2** (same family as CLI 8.2.30).
2. Confirm what the **web** uses, e.g. a temporary route `return PHP_VERSION;` or `phpinfo();` **then remove it**.
3. This repo sets **`config.platform-check`** to **`false`** so Composer does not ship the strict bootstrap check (avoids a fatal when the panel lags). Prefer fixing the panel PHP to 8.2 anyway; after changing it, you can set **`platform-check`** back to **`true`** if you want the guard again. After any change, run **`composer dump-autoload`** in **`public_html`**.

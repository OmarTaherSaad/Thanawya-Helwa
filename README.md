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

## Website shows the error but SSH `php -v` is 8.2+

Laravel 12 calls **`ReflectionFunction::isAnonymous()`**, which requires **PHP 8.2+**. If SSH shows 8.4 but the site fatals with *undefined method ReflectionFunction::isAnonymous()*, the **web** process is still on an older PHP.

On Hostinger / cPanel, **CLI** and **web** often differ. A common cause is the **root** `.htaccess` (gitignored, lives on the server only) pinning an old handler:

```apache
# php -- BEGIN cPanel-generated handler, do not edit
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php81 .php .php8 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit
```

That block overrides hPanel’s PHP version for every request routed through `public_html`.

**Fix:** edit `public_html/.htaccess` and either:

1. Update the handler to match your target version, e.g. `application/x-httpd-ea-php84`, or
2. Remove the entire cPanel `AddHandler` block and set PHP 8.2+ in **hPanel → PHP Configuration**.

Then confirm **web** PHP (not SSH):

```bash
echo '<?php echo PHP_VERSION;' > public/_php-check.php
curl -s https://thanawyahelwa.org/_php-check.php
rm public/_php-check.php
```

After any change, run in **`public_html`**:

```bash
rm -f bootstrap/cache/*.php
composer dump-autoload -o
php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

This repo sets **`config.platform-check`** to **`false`** so Composer does not ship the strict bootstrap check (avoids a fatal when the panel lags). Prefer fixing web PHP to 8.2+ anyway; you can set **`platform-check`** back to **`true`** once web and CLI match.

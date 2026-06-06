# SEO deployment notes

## Canonical host (`www` vs apex)

1. Choose one public URL (e.g. `https://www.thanawyahelwa.org`).
2. Set `APP_URL` in production `.env` to **exactly** that URL (scheme + host, no trailing path).
3. Keep `SEO_CANONICAL_HOST_REDIRECT=true` (default). The app will **301** any request whose `Host` header does not match `APP_URL` to the same path on `APP_URL`.
4. Run `php artisan config:cache` after changing `.env`.

Behind Hostinger / Cloudflare / other reverse proxies, ensure `TrustProxies` sees the real client protocol and host (`APP_URL` must stay HTTPS if the site is HTTPS). Set `TRUSTED_PROXIES=*` in `.env` only if your platform docs recommend it.

## Sitemap (`/sitemap.xml`)

If `/sitemap.xml` returns **500**, typical causes:

- Pending migrations (`unifac` / `universities` `slug`, `is_active`, etc.). Run `php artisan migrate --force`.
- Laravel PageSpeed corrupting XML (mitigated by `config/laravel-page-speed.php` skips for `sitemap.xml`, `sitemap-*`, `robots.txt`).

## `X-Powered-By`

`RemoveUnwantedResponseHeaders` strips `X-Powered-By` from the Symfony response when present. For complete removal at the PHP layer, also set `expose_php = Off` in `php.ini` on the server.

## Backlinks

Not fixable in application code; grow links from partners, press, and quality content over time.

#!/usr/bin/env bash
# Production deploy on the app server. Called from GitHub Actions after
# resetting to origin/deploy. Keep downtime to composer+artisan only.
set -euo pipefail

APP_DIR="${APP_DIR:-$HOME/domains/thanawyahelwa.org/public_html}"
cd "$APP_DIR"

C_OK='\033[1;32m'
C_IN='\033[1;36m'
C_ERR='\033[1;31m'
C_DIM='\033[2m'
C_OFF='\033[0m'

ok()   { printf '%b✓%b %s\n' "$C_OK" "$C_OFF" "$*"; }
info() { printf '%b→%b %s\n' "$C_IN" "$C_OFF" "$*"; }
fail() { printf '%b✗%b %s\n' "$C_ERR" "$C_OFF" "$*" >&2; }

STARTED=$(date +%s)
MAINT=0

bring_up() {
  if (( MAINT == 1 )); then
    php artisan up >/dev/null 2>&1 || true
    MAINT=0
  fi
}

on_exit() {
  local ec=$?
  bring_up
  if (( ec != 0 )); then
    fail "deploy failed after $(( $(date +%s) - STARTED ))s (exit ${ec})"
  fi
}
trap on_exit EXIT

step() {
  local label=$1
  shift
  info "$label"
  "$@"
  ok "$label"
}

SHA=$(git rev-parse --short HEAD)
info "sha ${SHA}  php $(php -r 'echo PHP_VERSION;')"

step "clear stale bootstrap cache" bash -c 'rm -f bootstrap/cache/*.php'

export COMPOSER_HOME="${COMPOSER_HOME:-$HOME/.config/composer}"
step "composer install" composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --ansi

info "maintenance on"
php artisan down --retry=30 --no-ansi >/dev/null
MAINT=1
ok "maintenance on"

step "rebuild caches" bash -c 'php artisan optimize:clear --no-ansi && php artisan config:cache --no-ansi && php artisan route:cache --no-ansi && php artisan view:cache --no-ansi'
step "migrate" php artisan migrate --force --no-ansi
step "restart queues" php artisan queue:restart --no-ansi

info "maintenance off"
php artisan up --no-ansi >/dev/null
MAINT=0
ok "maintenance off"

DUR=$(( $(date +%s) - STARTED ))
printf '\n%bdeployed%b %s in %ss\n' "$C_OK" "$C_OFF" "$SHA" "$DUR"
printf '%b%s%b\n' "$C_DIM" "$(git log -1 --format='%s')" "$C_OFF"

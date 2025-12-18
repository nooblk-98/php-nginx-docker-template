<div align="center">
  <img src="./images/logo.svg" width="360" alt="php-nginx-docker logo" />

# php-nginx-docker-template

Production-ready PHP-FPM + Nginx container stack for local development, CI images, and lightweight deployments.

  <div>
    <a href="https://hub.docker.com/r/lahiru98s/php-nginx-docker-template"><img src="https://img.shields.io/docker/pulls/lahiru98s/php-nginx-docker-template.svg" alt="Docker pulls" /></a>
    <a href="https://github.com/nooblk-98/php-nginx-docker-template/releases"><img src="https://img.shields.io/github/v/release/nooblk-98/php-nginx-docker-template?logo=github" alt="Latest release" /></a>
    <a href="https://github.com/nooblk-98/php-nginx-docker-template/actions/workflows/build-and-push.yml"><img src="https://github.com/nooblk-98/php-nginx-docker-template/actions/workflows/build-and-push.yml/badge.svg" alt="CI" /></a>
    <a href="https://creativecommons.org/licenses/by-nc/2.0/"><img src="https://img.shields.io/badge/License-CC%20BY--NC%202.0-blue.svg" alt="License: CC BY-NC 2.0" /></a>
  </div>
</div>

---

Hardened Nginx + PHP-FPM on Alpine, tuned for fast startup, low memory, and predictable behavior. Out of the box you get:
- Non-root runtime, locked-down defaults, gzip/cache tuning, and basic security headers.
- Supervisor + tini for graceful shutdowns and managed services (nginx, php-fpm).
- Prebaked Dockerfiles for PHP 7.4, 8.1, 8.2, 8.3, and 8.4 (edge) with opcache tweaks.
- Health endpoints `/fpm-ping` and `/fpm-status` (localhost only) and a sample dashboard showing PHP limits/extensions.

## Quick start (compose)
```bash
docker compose up -d
open http://localhost:8080
```

## Build from source
```bash
# Default: PHP 8.3 on Alpine 3.20
docker build -t php-nginx:8.3 .

# Override PHP/Alpine versions (must exist in apk repos)
docker build -t php-nginx:8.2 --build-arg PHP_VERSION=82 --build-arg ALPINE_VERSION=3.19 .
```

### Version matrix (prebaked Dockerfiles)
- PHP 7.4 (Alpine 3.15): `./php74/Dockerfile`
- PHP 8.1 (Alpine 3.18): `./php81/Dockerfile`
- PHP 8.2 (Alpine 3.20): `./php82/Dockerfile`
- PHP 8.3 (Alpine 3.20): `./php83/Dockerfile`
- PHP 8.4 (Alpine edge): `./php84/Dockerfile` (also tagged `latest`)

## Run (single container)
```bash
docker run --rm -p 8080:8080 php-nginx:8.3
```
Open http://localhost:8080 after the container starts.

## Images & registries
- GHCR: `ghcr.io/<owner>/php-nginx:<tag>` (8.4 also `latest`). CI uses the built-in `GITHUB_TOKEN`.
- Docker Hub: `docker.io/<dockerhub_username>/php-nginx:<tag>`. Provide `DOCKERHUB_USERNAME` and `DOCKERHUB_TOKEN` secrets in GitHub Actions to push automatically.

Manual push example (Docker Hub):
```bash
docker build -t youruser/php-nginx:8.3 .
docker login -u "$DOCKERHUB_USERNAME" -p "$DOCKERHUB_TOKEN"
docker push youruser/php-nginx:8.3
```

## Compose overrides
`docker-compose.yml` mounts `configs.php_overrides` into `/etc/php${PHP_VERSION}/conf.d/99-overrides.ini`. Override via env (in a `.env` file or your shell):
```bash
EXPOSE_PHP=Off
DISPLAY_ERRORS=Off
LOG_ERRORS=On
MEMORY_LIMIT=256M
MAX_EXECUTION_TIME=60
MAX_INPUT_TIME=60
POST_MAX_SIZE=32M
UPLOAD_MAX_FILESIZE=32M
DEFAULT_CHARSET="UTF-8"
PHP_VERSION=83 # compose maps this to the correct conf.d path
```
Then run `docker compose up -d`.

## Common troubleshooting
- `apk add php81-* not found`: use the Alpine release that ships that PHP minor (8.1 => Alpine 3.18). PHP 8.4 currently needs `edge`.
- `permission denied` on sockets/logs: ensure the container runs as `app` and mounts are writable by the `app` UID/GID (created in the Dockerfile).
- Slow builds on CI: enable buildx cache with `cache-from/cache-to` (type=gha) in the workflow.
- Healthcheck failing: confirm `/run/php/php-fpm.sock` exists and nginx points to it; hit `/fpm-ping` inside the container for a quick check.

## Highlights
- Minimal Alpine footprint, non-root by default, gzip/cache and header hardening applied.
- Supervisor-managed services with tini as init for clean signal handling.
- PHP-FPM over unix socket, tightened pool settings, and opcache tuned for speed.
- Nginx hides server details and exposes `/fpm-ping` + `/fpm-status` for health checks (localhost only).

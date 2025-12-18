<div align="center">
  <img src="./images/logo.svg" width="360" alt="php-nginx-docker logo" />

# php-nginx-docker-template

PHP + Nginx Docker setup for local development and production-ready deployments.

  <div>
    <a href="https://hub.docker.com/r/lahiru98s/php-nginx-docker-template "><img src="https://img.shields.io/docker/pulls/lahiru98s/php-nginx-docker-template .svg" alt="Docker UI pulls" /></a>
    <a href="https://github.com/nooblk-98/lighthouse/releases"><img src="https://img.shields.io/github/v/release/nooblk-98/lighthouse?logo=github" alt="Latest release" /></a>
    <a href="https://github.com/nooblk-98/lighthouse/actions/workflows/docker-build-push.yml"><img src="https://github.com/nooblk-98/lighthouse/actions/workflows/docker-build-push.yml/badge.svg" alt="CI" /></a>
     <a href="https://creativecommons.org/licenses/by-nc/2.0/">
    <img src="https://img.shields.io/badge/License-CC%20BY--NC%202.0-blue.svg" alt="License: CC BY-NC 2.0" />
  </div>
</div>

---


# php-nginx-docker-template
Hardened, lightweight PHP-FPM + Nginx container based on Alpine. Ships with sensible defaults, tuned opcache, non-root runtime, and health checks for production-style deployments.

## Build
```bash
# PHP 8.3 on Alpine 3.20 (defaults)
docker build -t php-nginx:8.3 .

# Override PHP/Alpine versions if the matching apk packages exist
docker build -t php-nginx:8.2 --build-arg PHP_VERSION=82 --build-arg ALPINE_VERSION=3.19 .
```

### Version matrix (prebaked Dockerfiles)
- PHP 7.4 (Alpine 3.15): `./php74/Dockerfile`
- PHP 8.1 (Alpine 3.18): `./php81/Dockerfile`
- PHP 8.2 (Alpine 3.20): `./php82/Dockerfile`
- PHP 8.3 (Alpine 3.20): `./php83/Dockerfile`
- PHP 8.4 (Alpine edge): `./php84/Dockerfile` (also tagged `latest`)

## Run
```bash
docker run --rm -p 8080:8080 php-nginx:8.3
```
Then open http://localhost:8080.

### Compose overrides
`docker-compose.yml` mounts `configs.php_overrides` into `/etc/php${PHP_VERSION}/conf.d/99-overrides.ini`. Override via env:
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
PHP_VERSION=83 # used by compose to map config path
```
Add a `.env` file or set env vars before `docker compose up -d`.

### Common troubleshooting
- `apk add php81-* not found`: use the matching Alpine that ships that PHP minor (8.1 => Alpine 3.18). 8.4 currently requires `edge`.
- `permission denied` on sockets/logs: ensure `USER` is `app` and mounts are writable by UID/GID of `app` (default added in Dockerfile).
- Slow builds on CI: enable buildx cache with `cache-from/cache-to` (type=gha) in the workflow.
- Healthcheck failing: confirm `/run/php/php-fpm.sock` exists and nginx uses that path; check `/fpm-ping` locally in the container.

## Highlights
- Runs as non-root with minimized package set and gzip/cache settings.
- Supervisor managed processes with tini as init for graceful shutdowns.
- PHP-FPM on unix socket with tightened pool settings and opcache tuned for speed.
- Nginx hides server details, adds basic security headers, and exposes `/fpm-ping` + `/fpm-status` for health checks (localhost only).

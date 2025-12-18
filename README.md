<div align="center">
  <img src="./images/logo.svg" width="360" alt="php-nginx-docker logo" />

# PHP-Nginx Docker Template

**Production-ready PHP-FPM + Nginx container stack for modern web applications**

[![Docker Pulls](https://img.shields.io/docker/pulls/lahiru98s/php-nginx-docker-template.svg)](https://hub.docker.com/r/lahiru98s/php-nginx-docker-template)
[![GitHub Release](https://img.shields.io/github/v/release/nooblk-98/php-nginx-docker-template?logo=github)](https://github.com/nooblk-98/php-nginx-docker-template/releases)
[![CI/CD](https://github.com/nooblk-98/php-nginx-docker-template/actions/workflows/build-and-push.yml/badge.svg)](https://github.com/nooblk-98/php-nginx-docker-template/actions/workflows/build-and-push.yml)
[![License: AGPL](https://img.shields.io/badge/license-AGPL-blue.svg)](http://www.gnu.org/licenses/agpl-3.0)

[Features](#-features) • [Quick Start](#-quick-start) • [Documentation](#-documentation) • [Contributing](#-contributing)

</div>

---

## 📖 Overview

A battle-tested, production-grade Docker template combining **Nginx** and **PHP-FPM** on Alpine Linux. Engineered for security, performance, and developer productivity with zero-configuration deployment and enterprise-grade defaults.

**Perfect for:**
- 🚀 Production deployments
- 💻 Local development environments
- 🔄 CI/CD pipelines
- 📦 Microservices architecture
- 🌐 API backends and web applications

### What's Included

- **Alpine Linux** - Minimal footprint (~50MB base image)
- **PHP-FPM** - Optimized with opcache, APCu, and performance tuning
- **Nginx** - Hardened configuration with security headers
- **Supervisor** - Process management with auto-restart
- **Tini** - Proper init system for graceful shutdowns
- **Health Checks** - Built-in endpoints for monitoring

---

## ✨ Features
### 🔒 Security & Production Hardening
- **Non-root runtime** - Container runs as unprivileged `app` user, reducing attack surface
- **Locked-down defaults** - Nginx hides server details, security headers applied
- **Minimal Alpine base** - Smaller attack surface, fewer vulnerabilities to patch

### ⚡ Performance Optimization
- **Tuned opcache** - Pre-configured for speed with sensible caching defaults
- **Unix socket communication** - PHP-FPM and Nginx communicate via socket (faster than TCP)
- **Gzip & caching** - Built-in compression and browser caching headers
- **Fast startup** - Lightweight Alpine base means quick container spin-up

### 🔧 Flexibility & Compatibility
- **Multiple PHP versions** - Pre-built images for PHP 7.4, 8.1, 8.2, 8.3, 8.4
- **Easy customization** - Override PHP settings via environment variables or `.env` file
- **Version-locked Alpine** - Each PHP version paired with compatible Alpine release

### 💻 Developer Experience
- **Works out-of-the-box** - Just run `docker compose up` and start coding
- **Health endpoints** - Built-in `/fpm-ping` and `/fpm-status` for monitoring
- **Sample dashboard** - Included PHP info page to verify configuration
- **CI/CD ready** - GitHub Actions workflow included for automated builds

### 🛠️ Operational Reliability
- **Graceful shutdowns** - Tini init system handles signals properly
- **Supervised processes** - Supervisor manages nginx + php-fpm, auto-restarts on failure
- **Clear error handling** - Proper logging configuration and troubleshooting guide


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

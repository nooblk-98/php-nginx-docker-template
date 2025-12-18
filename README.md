# php-nginx-docker-template
Hardened, lightweight PHP-FPM + Nginx container based on Alpine. Ships with sensible defaults, tuned opcache, non-root runtime, and health checks for production-style deployments.

## Build
```bash
# PHP 8.3 on Alpine 3.20 (defaults)
docker build -t php-nginx:8.3 .

# Override PHP/Alpine versions if the matching apk packages exist
docker build -t php-nginx:8.2 --build-arg PHP_VERSION=82 --build-arg ALPINE_VERSION=3.19 .
```

## Run
```bash
docker run --rm -p 8080:8080 php-nginx:8.3
```
Then open http://localhost:8080.

## Highlights
- Runs as non-root with minimized package set and gzip/cache settings.
- Supervisor managed processes with tini as init for graceful shutdowns.
- PHP-FPM on unix socket with tightened pool settings and opcache tuned for speed.
- Nginx hides server details, adds basic security headers, and exposes `/fpm-ping` + `/fpm-status` for health checks (localhost only).

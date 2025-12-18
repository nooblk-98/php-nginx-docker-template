## PHP + Nginx (Alpine)

Production-ready PHP-FPM + Nginx stack on Alpine. Hardened, lightweight, and tuned for fast startups and low memory use.

**Highlights**
- Non-root runtime, secure defaults, gzip/cache and basic security headers
- Opcache/APCu tuned for speed; PHP-FPM over unix socket
- Supervisor + tini for graceful shutdowns and managed services
- Health endpoints `/fpm-ping` and `/fpm-status` (localhost)
- Prebaked variants: PHP 7.4, 8.1, 8.2, 8.3, 8.4 (edge)

**Quick start**
```bash
docker run --rm -p 8080:8080 lahiru98s/php-nginx-docker-template:8.3
```
Then open http://localhost:8080.

**Common env overrides**
```
EXPOSE_PHP=Off
DISPLAY_ERRORS=Off
MEMORY_LIMIT=256M
POST_MAX_SIZE=32M
UPLOAD_MAX_FILESIZE=32M
```

Visit the [GitHub Repository](https://github.com/nooblk-98/php-nginx-docker-template) for the full guide.

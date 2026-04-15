# PHP + MySQL + Apache + Xdebug (with directory browsing)

## Run
```
docker compose up -d --build
```

Open:
- App: http://localhost:8080/
- Xdebug info: http://localhost:8080/xdebug_info.php
- phpMyAdmin: http://localhost:8081/  (user/password: root / password; root)

## VS Code debugging
1) Install "PHP Debug" (by Xdebug)
2) Open this folder in VS Code
3) Set a breakpoint in `php/index.php`
4) Run: **Listen for Xdebug (Docker)** (F5), then refresh the browser

## Notes
- Directory browsing is enabled via `apache-config.conf` mounted to `/etc/apache2/conf-enabled/zz-dir-browsing.conf`.
- We intentionally **do not** use `container_name:` so multiple copies of this folder can run without name conflicts.
- If ports (8080/8081/3306) are busy, change them in `docker-compose.yml`.

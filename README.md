# Poo26

## TODO

- [ ] Temp link option
- Document Models and improve README
- Document flux credentials in github etc
- 
## Useful commands

Command to update UI snapshots:

```bash
php artisan test --update-snapshots
```

Run tests in parallel

```bash
php artisan test --parallel

```

## Building

```bash
DOCKER_BUILDKIT=1
docker build \
  --secret id=composer_auth,src=auth.json \
  -t poo26 .
```

```bash
DOCKER_BUILDKIT=1 docker build --secret id=composer_auth,env=COMPOSER_AUTH . 
```

## Notes

- Secret auth.json in github actions needs to be single line json
- Trusted proxies
- Admin_email env variable for admin panel access

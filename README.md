# Poo26

## TODO

- [ ] Temp link option
- [ ] Admin panel
- Document Models and improve README
- Document flux credentials in github etc

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
docker build \
  --secret id=composer_auth,src=auth.json \
  -t poo26 .
```

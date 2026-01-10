<picture style="text-align: center;">
  <source media="(prefers-color-scheme: dark)" srcset="public/assets/images/logo/logo-light.png">
  <img alt="WishWaffle Logo" src="public/assets/images/logo/logo.png" width="200">
</picture>

# Poo26

Poo26 is the 2026 version of Poo.ink the URL shortener. Poo26 is built with...

- Laravel 12
- TailwindCSS v4
- Livewire 3
- Filament Admin Panel
- PestPHP 4 for testing
- FluxUi components

## Requirements

- PHP 8.3+
- Composer
- NodeJS 20+
- Docker (optional, for building images)
- Make

[Get Started locally](#getting-started-locally)


## Paid Dependencies

Poo26 uses [FluxUi](https://fluxui.dev/) pro components for the user interface. This is a paid package and a license is required to install the components from their private repository.

If you have a license you can create an auth.json file with your credentials. See [Flux documentation](https://fluxui.dev/docs/installation) for more details.

use the following command to generate an empty auth.json file:

```bash
php artisan flux:activate
```

## Environment Variables

Laravel uses environment variables to configure various aspects of the application. Most of the defaults are set in the
`.env.example` file. You can copy this file to `.env` and modify it as needed.

To disable stack traces in browser set `APP_DEBUG=false` in your `.env` file.

## Getting started locally
1. Clone the repository

   ```bash
   git clone git@github.com:angus-websites/poo26.git
   ```
2. Navigate to the project directory

   ```bash
    cd poo26
    ```
3. Install PHP dependencies using Composer

   > **_Licence:_**  Some dependencies require a valid license and auth.json file to install correctly see [Paid Dependencies](#paid-dependencies)

    ```bash
    composer install
    ```

4.  Install JavaScript dependencies using npm, or Bun
    ```bash
    npm install
    # or
    bun install
    ```
5. Copy the example environment file and configure your [environment variables](#environment-variables)
    ```bash
    cp .env.example .env
    ```
6. Generate an application key (APP_KEY) (if not already done)
    ```bash
    php artisan key:generate
    ```
7. Run database migrations
    ```bash
    php artisan migrate
    ```
8. Start Vite development server
    ```bash
    npm run dev
    # or
    bun run dev
    ```
9. Start the Laravel development server
    ```bash
    php artisan serve
    ```
   

## Github Actions

The project includes two Github Actions workflows for CI/CD.

### ci.yaml

This workflow runs on every pull request to the `main` branch. It will...

1. Check you have updated the project version in `composer.json`
2. Run all the Pest tests (excluding screenshot diff tests)

#### Secrets

This workflow expects the following secrets to be set in the `Testing` environment of your repository settings:

1. `FLUX_USERNAME` - The email address associated with your FluxUi account
2. `FLUX_LICENSE_KEY` - Your FluxUi license key

### cd.yaml

This workflow runs on every push to the `main` branch. It will...

1. Build and push a Docker image to GitHub Container Registry
2. Deploy the app to a CapRover server

#### Secrets

This workflow expects the following secrets to be set in the `Production` environment of your repository settings:

1. `COMPOSER_AUTH` - The contents of your `auth.json` file for installing paid dependencies, note this secret MUST be a single line JSON string otherwise the workflow will fail.
2. `CAP_SERVER_URL` - The base URL of your CapRover server e.g `https://captain.yourdomain.com`
3. `CAP_APP_NAME` - The name of the app on your CapRover server e.g `poo26`
4. `CAP_APP_TOKEN` - The token for your CapRover app




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

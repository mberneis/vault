## Vault

**Vault** is a port of [PasteVault](https://github.com/userscape/pastevault) by UserScape. It's powered by [Laravel](https://laravel.com) and [Semantic UI](http://semantic-ui.com).

## Requirements

- PHP 8.5+
- Composer 2

## Usage

1. Clone the repo `git clone git@github.com:koomai/vault.git`
2. `cd` into the `vault` directory and run `composer setup`. This installs dependencies, copies `.env.example` to `.env`, and generates `APP_KEY`.
3. Run `php artisan serve` and navigate to `http://localhost:8000` on your browser.

Run the tests with `composer test`.

No database is needed: secrets are stored in the cache (`CACHE_STORE=file` by default) and sessions use files.

## Disclaimer

This repo was created as an exercise to dabble with Lumen, and has since been moved to Laravel 12. Use at your own risk.

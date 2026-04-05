# Contributing

Contributions are welcome and will be credited.

## Before you start

- Open issues for **bugs** or **larger ideas** so direction is clear before you invest time.
- Check existing **issues** and **pull requests** to avoid duplicates.

## Requirements

- **PHP** ^8.2, **Filament** ^5.0 (see `composer.json`).
- **Tests:** Any behaviour change should include or update a **Pest** test. Run:

  ```bash
  composer install
  composer test
  ```

- **Code style:** Format PHP with **Laravel Pint** (project config):

  ```bash
  vendor/bin/pint
  ```

  Or only changed files: `vendor/bin/pint --dirty`.

- **Static analysis (optional but appreciated):**

  ```bash
  composer analyse
  ```

- **Documentation:** Update `README.md` (and `CHANGELOG.md` under **Unreleased**) when user-facing behaviour changes.

## Pull requests

- Target the **`5.x`** branch unless maintainers ask otherwise.
- **One concern per PR** (feature or fix), small and reviewable.
- Use a **clear title** and describe **what** changed and **why**.
- CI is expected to pass (tests, PHPStan, and Pint on GitHub Actions).

## Security

Do **not** open public issues for security problems. See [SECURITY.md](SECURITY.md).

Thanks for helping improve the package.

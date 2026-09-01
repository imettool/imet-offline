# `imet-offline` - Technical documentation

1. [Architecture](#1-architecture)
2. [Tech Stack](#2-tech-stack)
3. [Domain Model](#3-domain-model)
4. [Directory Map](#4-directory-map)
5. [Routes & Controllers](#5-routes--controllers)
6. [Key Services & Helpers](#6-key-services--helpers)
7. [Application Flow](#7-application-flow)
8. [Development Setup](#8-development-setup)
9. [Build & Publish a Release](#9-build--publish-a-release)

---

## 1. Architecture

The repo is intentionally **a thin host shell** over the `imettool/imet-core` package. The core domain
(IMET and OECM assessments, scoring, reports, etc..) lives in `imet-core`. This repo only
adds:

- An **Electron host** (via NativePHP) that runs a local PHP server inside a desktop window.
- A **first-boot setup wizard** (5 steps) that initializes user, species, and protected-area datasets.
- A **settings** page for user profile and other configuration.
- A *GitHub*-based **auto-updater**.
- A **SQLite** database

## 2. Tech Stack

| Layer            | Choice                                            |
|------------------|---------------------------------------------------|
| Runtime          | PHP 8.4, Node 22                                  |
| Framework        | Laravel 13.x                                      |
| Desktop wrapper  | NativePHP/Desktop 2.x                             |
| Frontend builder | Vite                                              |
| DB               | SQLite                                            |
| Static analysis  | PHPStan / Larastan, Rector, Laravel Pint          |

## 3. Domain Model

Most models are inherited from `imet-core`. This repo overrides only what is needed for the offline use case.

| Model           | Inherits from                        | Purpose                                                                                                                                                           |
| --------------- | ------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `User`          | `ImetCore\Models\User\User`          | Singleton user (id=0); fillable: `first_name`, `last_name`, `organisation`, `function`, `country` (iso3), `imet_role`. Password hardcoded `sup3rS3cret!` on save. |
| `Country`       | `ImetCore\Models\Country`            | Country lookup keyed by `iso3`; provides selection list.                                                                                                          |
| `ProtectedArea` | `ImetCore\Models\ProtectedArea`      | WDPA / OECM protected areas (factory added).                                                                                                                      |
| `Settings`      | `Illuminate\Database\Eloquent\Model` | Singleton row id=0 — `proxy_host`, `proxy_port`, `proxy_user`, `proxy_password`.                                                                                  |

The full IMET domain (Species, ProtectedArea forms, OECM forms, scoring tables, etc.) lives in
`vendor/imettool/imet-core/src/Models`.

## 4. Directory Map

```
imet_offline/
├── app/
│   ├── Console/Commands/        imet:* artisan commands (Build, Publish, ResetDevEnv, …)
│   ├── Events/                  TaskProgressing, ZoomIn/Out/Reset hotkey events
│   ├── Helpers/                 Domain helpers — most extend imet-core equivalents
│   ├── Http/
│   │   ├── Controllers/         SetupController, SettingsController, UserController
│   │   └── Middleware/Authenticate.php  forces login of user id=0
│   ├── Jobs/InitializeOfflineTool.php   first-boot env / app-update.yml patcher
│   ├── Listeners/               AppListener, MigrationsListener, UpdaterListener
│   ├── Models/                  User, Country, ProtectedArea, Settings
│   └── Providers/
│       ├── AppServiceProvider.php          registers selection list, custom_text validator
│       └── NativeAppServiceProvider.php    opens window, registers hotkeys, php.ini
├── bootstrap/
├── config/
│   ├── auth.php, database.php   auth + SQLite config
│   ├── csp.php                  spatie/laravel-csp policies
│   ├── imet-core.php            override for User model + route prefixes
│   └── nativephp.php            window, updater, queue worker, build hooks
├── database/
│   ├── offline.sqlite           runtime DB (gitignored)
│   ├── migrations/              users, sessions, settings, jobs, cache
│   ├── seeders/, factories/
│   └── *.csv                    bundled seed data
├── lang/                        localization files (en, fr, pt, sp)
├── public/                      compiled assets (build/), icon, basket
├── resources/
│   ├── index.js, index.css      entry: imports modular-forms + imet-core asset bundles
│   ├── js/                      per-feature Vue apps:
│   └── views/                   Blade templates (home, setup steps, settings)
├── routes/                      web.php, api.php
├── composer.json                version field is the source of truth for app version
└── package.json
```

## 5. Routes & Controllers

### `routes/web.php`

| Method | URI                    | Name                  | Controller                                     |
| ------ | ---------------------- | --------------------- | ---------------------------------------------- |
| GET    | `/`                    | —                     | `SetupController@index`                        |
| GET    | `/home`                | `home`                | view `offline.home`                            |
| GET    | `/setup`               | `setup.info`          | `SetupController@info`                         |
| GET    | `/setup/user`          | `setup.user`          | `SetupController@user`                         |
| PATCH  | `/setup/user`          | `setup.user.save`     | `SetupController@user_save`                    |
| GET    | `/setup/species`       | `setup.species`       | `SetupController@species`                      |
| PATCH  | `/setup/species`       | `setup.species.save`  | `SetupController@species_save`                 |
| GET    | `/setup/wdpas`         | `setup.wdpas`         | `SetupController@wdpas`                        |
| PATCH  | `/setup/wdpas`         | `setup.wdpas.save`    | `SetupController@wdpas_save`                   |
| GET    | `/setup/done`          | `setup.done`          | `SetupController@done`                         |
| GET    | `/settings`            | `settings`            | `SettingsController@index`                     |
| PATCH  | `/settings/update`     | `settings_update`     | `SettingsController@update`                    |
| PATCH  | `/update_offline_user` | `update_offline_user` | `SettingsController@user`                      |
| POST   | `/file/upload`         | `upload.file`         | `ModularForms\…\UploadFileController@upload`   |
| GET    | `/file/{hash}`         | `file`                | `ModularForms\…\UploadFileController@download` |
| GET    | `/info`                | —                     | `phpinfo()` (debug)                            |

All web routes are implicitly authenticated via the `Authenticate` middleware, which force-logs in user id=0.


## 6. Key Services & Helpers

| File                                     | Role                                                                                                                                                      |
| ---------------------------------------- |-----------------------------------------------------------------------------------------------------------------------------------------------------------|
| `App\Helpers\ImetEnv`                    | `isFirstBoot()` (Species count < 10), `getVersion()` (reads `nativephp.version`).                                                                         |
| `App\Helpers\OfflineLog`                 | `info/error/warning/debug($msg, $verbose)` — writes to log + optional stdout.                                                                             |
| `App\Helpers\CSVReader`                  | Generator-based chunked CSV parser; default chunk = 1000 rows.                                                                                            |
| `App\Helpers\SpeciesUpdater`             | Extends `ImetCore\Helpers\SpeciesUpdater` to emit `TaskProgressing` events for Vue UI.                                                                    |
| `App\Helpers\ProtectedAreaUpdaterCSV`    | Orchestrates WDPA/OECM ZIP extraction + CSV chunked parsing, emits progress events.                                                                       |
| `App\Helpers\SelectionList`              | Resolver override (modular-forms): non-filtered country list.                                                                                             |
| `App\Helpers\DependencyParser`           | NOTICE.md generation                                                                                                                                      |
| `App\Jobs\InitializeOfflineTool`         | First-prod-boot patcher: forces `LOG_LEVEL=debug` in `.env`; injects updater token into `app-update.yml`; relaunches if either changed.                   |
| `App\Listeners\AppListener`              | Hooks `Native\Desktop\Events\App\ApplicationBooted` → init job + autoupdater check.                                                                       |
| `App\Listeners\UpdaterListener`          | Logs every NativePHP AutoUpdater event                                                                                                                    |
| `App\Listeners\MigrationsListener`       | Logs migration start/end.                                                                                                                                 |
| `App\Providers\NativeAppServiceProvider` | Opens main window (1200×800), registers Zoom hotkeys (with multiple keymaps for ITA layout), sets PHP ini directives (2 GB upload, no execution timeout). |
| `App\Providers\AppServiceProvider`       | Registers SelectionList resolver; defines `custom_text` validator (unicode + a few punctuation chars).                                                    |

## 7. Application Flow

### First boot

When the application starts, `SetupController@index` checks `ImetEnv::isFirstBoot()`. The heuristic is
**`Species::count() < 10`** — if true, the wizard is shown.

Wizard steps (`SetupController::TIMELINE`):

1. **info** — welcome screen.
2. **user** — fill in offline user profile (name, organisation, country).
3. **species** — populate the species + vernacular_names tables from the bundled CSVs (Catalogue of Life).
4. **wdpas** — upload the WDPA/OECM CSV ZIP (downloaded from [Protected Planet](https://www.protectedplanet.net/));
   the `ProtectedAreaUpdaterCSV` helper extracts and parses it.
5. **done** — wizard complete; user is redirected to home.

Long-running steps (3, 4) emit `TaskProgressing` events to drive Vue progress bars.

### Subsequent boots

`AppListener` (on NativePHP `ApplicationBooted` event):

1. Logs the boot.
2. In production only: dispatches `InitializeOfflineTool` synchronously (one-time `.env` and `app-update.yml` patcher).
3. In production only: triggers `AutoUpdater::checkForUpdates()`.

## 8. Development Setup

### Prerequisites

- PHP 8.4 with extensions listed by `php artisan imet:parse_php_extension`.
- Composer 2.x.
- Node 22.x
- A C/C++ toolchain (for native Electron deps on first install).

### First-time install

```bash
git clone https://github.com/imettool/imet-offline.git
cd imet-offline
cp .env.example .env

composer install            # also runs ide-helper, log-viewer:publish, native:install
npm install
npm run build               # or `npm run dev` for hot reload

php artisan key:generate
php artisan migrate         # creates database/offline.sqlite
```

### Running locally

```bash
# Run the desktop app + Vite dev server side by side
composer native:dev

# Or run only the NativePHP/Electron app
composer native:run
```

### Resetting the dev environment

To completely reset the local environment (clean caches, drop the DB, reinstall vendor + node_modules,
reset NativePHP):

```bash
php artisan imet:reset_dev_environment
# or, clean only (no rebuild)
php artisan imet:reset_dev_environment --clean-only
```

### Environment variables

The most relevant `.env` key is `GITHUB_TOKEN`. It must be populated with a GitHub Personal Access Token (PAT) and it is required to
publish releases to GitHub. For security, the token should have the minimum scopes needed (repo scope for a repo-specific PAT,
or a fine-grained PAT with "Contents: write" on `imettool/imet-offline`).

## 9. Build & Publish a Release

This guide assumes you are publishing to the **GitHub Releases** of `imettool/imet-offline`.

### 9.1 — Pre-flight

1. Make sure your working tree is clean and the version branch is merged into `main`.
2. **Bump the version** in `composer.json`:

   ```diff
   -    "version": "1.2.1",
   +    "version": "1.2.0",
   ```

   This single field drives `nativephp.version`, the Electron `package.json`, the GitHub tag, and
   the auto-updater check.
3. (Optional) Regenerate the NOTICE file:

   ```bash
   composer notice-generator
   git add NOTICE.md
   ```
4. Be sure that the `.env` file is configured with the `GITHUB_TOKEN` Personal Access Tokens.

### 9.2 — Build only (no publish)

To compile a Windows installer locally **without** uploading it anywhere:

```bash
composer native:build
```

This invokes `php artisan imet:build`, which wraps NativePHP's `BuildCommand` hardcoded to `os=win`,
`arch=x64`. Pre/post hooks are configured in `config/nativephp.php` (`prebuild` runs `npm run build`).

The installer ends up in `nativephp/electron/dist/`.

### 9.3 — Build, publish, and create a GitHub draft release

```bash
composer native:publish
```

This invokes `php artisan imet:publish`, which:

1. Runs the prebuild hooks (`npm run build`).
2. Builds the Windows installer via `electron-builder`.
3. Uses `GITHUB_TOKEN` to **create a tag and a Draft Release** on `imettool/imet-offline`,
   uploading the `.exe`, blockmap, and `latest.yml` (the auto-updater feed).

The tag name comes from `composer.json`'s `version` (prefixed with `v` because `GITHUB_V_PREFIXED_TAG_NAME=true`).


### 9.4 — Promote the draft to a public release

`GITHUB_RELEASE_TYPE=draft` means the release is created hidden. To promote it:

1. Open the [Releases page](https://github.com/imettool/imet-offline/releases) on GitHub.
2. Locate the new **Draft** release (matching your version tag, e.g. `v1.2.0`).
3. Edit it by adding the release notes.
4. Make sure the **`latest.yml`** asset is attached — this is what the auto-updater reads.
5. Click **Publish release**.

> [!IMPORTANT]
> The auto-updater only sees published releases (not drafts). Until you click **Publish release**,
> existing installations will not detect the new version.

### 9.5 — Verify the auto-updater picks it up

1. Install a previous version on a test Windows machine.
2. Launch it; on `ApplicationBooted`, `AppListener` calls `AutoUpdater::checkForUpdates()`.
3. The `UpdaterListener` logs the lifecycle (`CheckingForUpdate`, `UpdateAvailable`, `DownloadProgress`,
   `UpdateDownloaded`, `Error`). Inspect logs at `storage/logs/laravel.log` or via the embedded
   `/log-viewer` route.
4. If `UpdateAvailable` fires, the user is prompted (via the `CheckUpdatesApp` Vue component) to apply the update.

### 9.6 — Hotfix / rebuild a release

If you need to rebuild the same version (e.g. fixed a packaging bug without bumping the code):

1. Delete the GitHub release **and** the corresponding tag.
2. Re-run `composer native:publish`.

If the version bumped, just publish the new version; the old draft can be discarded.

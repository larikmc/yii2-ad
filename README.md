# Yii2 Advertising Module (yii2-ad)

Universal advertising banners, blocks, and `<head>` network management module for Yii2 applications with device targeting (Desktop/Mobile), delayed script execution, cache invalidation, and administrative dashboard.

## Features

- **Ad Networks (`<head>`) Management**: Control global advertising network scripts (Yandex RTB, Digital Caramel, Adfinity, MPS/Mediascope, etc.) directly from the admin panel with instant caching and toggle switches.
- **`AdHeadWidget`**: Cleanly renders enabled advertising network header scripts in layouts with automatic device filtering and priority ordering.
- **Fixed-Position Segmented Toggles**: Polished UI with `[ Вкл | Откл ]` controls that never swap button positions, featuring live pulsing status indicators.
- **Device Targeting**: Serve separate banners for desktop and mobile, or universal formats.
- **Delayed Script Loading**: Configurable delay (0.5s – 3s) and frequency sampling (100%, 50%, 33%, etc.) to optimize Core Web Vitals and initial page load speed.
- **Robust Code Rendering**: Safe execution of Yandex RTB, Google AdSense, Market, Grattis, and custom HTML/JS banners without fragile string manipulations.
- **Automatic Cache Invalidation**: Updates in admin immediately clear position, network, and frontend caches.
- **Desync & Adfinity Auto-Embed Awareness**: Built-in notices distinguishing auto-embed networks (Adfinity) from position-based networks, with alerts when active banners belong to disabled networks.
- **Local Dev Preview**: Built-in developer preview card with 1-click live testing on `127.0.0.1` / `::1`.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```bash
composer require larikmc/yii2-ad
```

Run database migrations:

```bash
php yii migrate --migrationPath=@vendor/larikmc/yii2-ad/src/migrations
```

## Module Configuration (Backend)

Add the module to your `backend/config/main.php`:

```php
'modules' => [
    'ad' => [
        'class' => \larikmc\ad\Module::class,
        'accessRoles' => ['admin', 'adminPanel'], // or empty array [] to use global AccessControl
    ],
],
```

Admin routes:
- `/admin/ad/ad/index` — Banner management
- `/admin/ad/ad-position/index` — Placement positions
- `/admin/ad/ad-network/index` — Advertising network scripts (`<head>`)

## Frontend Usage

### 1. Header Scripts (`<head>`)

Render active advertising network head scripts in your main layout (e.g. `views/layouts/main.php` or `_head.php`):

```php
<?= \larikmc\ad\widgets\AdHeadWidget::widget() ?>
```

### 2. Banner Blocks (Body / Content)

To display a banner block in your views or layouts:

```php
<?= \larikmc\ad\widgets\AdWidget::widget([
    'position_id' => 1,
]) ?>
```

#### Options

- `position_id` *(int, required)*: The position ID configured in the admin panel.
- `isMobile` *(bool|null)*: Force mobile (`true`) or desktop (`false`). When `null`, automatically detects via user agent.
- `showDebug` *(bool|null)*: Control debug card preview on local development. Pass `?ad_debug=0` in the URL to test live banner execution.

## License

MIT

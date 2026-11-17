# Yii2 Advertising Module (yii2-ad)

Universal banner management module and frontend widget for Yii2 applications with device targeting (PC/Mobile), delayed script execution, cache invalidation, and admin dashboard.

## Features

- **Device Targeting**: Serve separate banners for desktop and mobile, or universal formats.
- **Delayed Script Loading**: Configurable delay (0.5s - 3s) and frequency sampling (100%, 50%, 33%, etc.) to optimize Core Web Vitals and initial page load speed.
- **Robust Code Rendering**: Safe execution of Yandex RTB, Google AdSense, Market, Grattis, and custom HTML/JS banners without fragile string manipulations.
- **Automatic Cache Invalidation**: Updates in admin immediately clear position and frontend caches.
- **Modern Admin UI**: Clean, responsive management interface compatible with Admin UI Kit.
- **Local Dev Preview**: Built-in developer preview card with 1-click live testing on `127.0.0.1` / `::1`.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```bash
composer require larikmc/yii2-ad
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

## Frontend Usage

To display an ad block in your views or layouts:

```php
echo \larikmc\ad\widgets\AdWidget::widget([
    'position_id' => 1,
]);
```

### Options

- `position_id` *(int, required)*: The position ID configured in the admin panel.
- `isMobile` *(bool|null)*: Force mobile (`true`) or desktop (`false`). When `null`, automatically detects via user agent.
- `showDebug` *(bool|null)*: Control debug card preview on local development. Pass `?ad_debug=0` in the URL to test live banner execution.

## License

MIT

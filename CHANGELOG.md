# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.0] - 2026-11-27

### Added
- **Admin Comment for Ad Blocks**: Added optional `comment` column (`m261127_120000_add_comment_to_ad_table`), form field, view detail row, and filterable column in `/admin/ad/ad/index`.

### Fixed
- **Fixed Width & Scrollable Code Column**: Gave the `code` column fixed `340px` width and bounded scrollable preview box (`.promo-code-block`) so it no longer collapses into a narrow vertical column.
- **Light Theme Soft Secondary Badges**: Added `.badge-soft-secondary` styling for light and dark themes so `margin_top` and `wait` badges remain clearly visible on light backgrounds.

## [1.1.0] - 2026-11-23

### Added
- **Ad Networks (`<head>`) Management**: New `ad_network` database table, `AdNetwork` model, and admin CRUD `/admin/ad/ad-network/index` for managing global advertising scripts (Yandex RTB, Digital Caramel, Adfinity, MPS/Mediascope).
- **`AdHeadWidget`**: Frontend widget to dynamically output active network scripts into the HTML `<head>`.
- **Fixed-Position Segmented Toggles**: Segmented toggle buttons `[ Вкл | Откл ]` with guaranteed button positions (On on left, Off on right) and active status indicators.
- **Adfinity Auto-Embed Notice**: Documentation and UI badges explaining that Adfinity uses auto-embedding scripts in `<head>` rather than manual banner placement positions.
- **Desync Warning**: Proactive warning on `/admin/ad/ad/index` when active banners belong to an advertising network that is disabled in `<head>`.
- **Migration `m261123_120000_create_ad_network_table.php`**: Reversible migration creating the `ad_network` table with default seed records.

### Changed
- Removed Adfinity from manual banner position partner choices in `Ad::partnerList()`.
- Modernized banner and position index grids to seamlessly match Admin UI Kit standards.

## [1.0.2] - 2026-11-17

### Fixed
- Replaced `ad-*` CSS class names and IDs with neutral prefixes to prevent false-positive blocking by AdBlock browser extensions.

## [1.0.1] - 2026-11-17

### Fixed
- Resolved widget view resolution to the package directory when subclassed or customized.

## [1.0.0] - 2026-11-17

### Added
- Initial release of `larikmc/yii2-ad` advertising management module.
- Device targeting (Desktop/Mobile/Universal).
- Delayed script execution and traffic sampling.
- Dynamic cache invalidation and developer preview card.

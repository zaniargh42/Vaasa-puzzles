# Changelog

All notable changes to this project are documented in this file.

## [0.2.0] — 2026-07-15

### Added
- Full support for three languages: Persian, English, and Finnish
- Laravel translation files in `lang/fa`, `lang/en`, and `lang/fi`
- Language switcher in the app header
- JSON translatable fields for cities, games, and stages
- Previous stage button on every stage page
- Review mode for revisiting completed stages without re-entering codes

### Changed
- Twelve Barrels game content is seeded in all three languages
- Page direction (RTL/LTR) follows the active locale

## [0.1.0] — 2026-07-15

### Added
- Initial scaffold with Laravel, Sail, Inertia, and Vue
- City and game selection flow
- Fifteen stages for the Twelve Barrels game in Vaasa
- Session-based game progress
- Stage text display with copyable codes
- Game flow tests

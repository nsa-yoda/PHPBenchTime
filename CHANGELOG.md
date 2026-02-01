# Changelog

All notable changes to this project will be documented in this file.

The format is inspired by [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

---

## [2.1.0] — 2026-02-01

### Added
- PHP 8.1+ support with enum-backed timer state (`TimerState`)
- Read-only public API via getters
- Strict typing for all time values (`float`)
- Composer-enforced PHP version requirement
- PHPUnit test suite updated for modern API
- GitHub Pages documentation (`docs/index.html`)

### Changed
- Internal state is now fully private and immutable from userland
- Timer state is represented using a PHP enum instead of constants
- `summary()` now reports active runtime (paused time excluded)
- Composer metadata modernized

### Fixed
- Incorrect integer typing for `microtime(true)` values
- Inconsistent pause accounting edge cases
- Ending a timer while paused now finalizes pause time automatically

---

## [2.0.0] — 2014-07-23

### Added
- Pause and unpause functionality
- Centralized lap system
- Detailed summary output
- Non-static API design

### Changed
- Complete internal rewrite
- Improved readability and extensibility

---

## [1.3.0]

### Added
- Lap support

---

## [1.2.0]

### Changed
- Transitioned from static to non-static namespaces

---

## [1.1.0]

### Changed
- Introduced static namespaces

---

## [1.0.0]

### Added
- Initial static release
- Basic benchmarking functionality
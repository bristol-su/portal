# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [3.4.0] - 2021-12-16

### Added
- Ability to duplicate an activity

## [3.3.5] - 2021-11-30

### Fixed
- Improved efficiency of airtable exports

## [3.3.4] - 2021-10-23

### Updated
- Several module dependencies with bug fixes

### Changed
- Support form schema version 3

## [3.3.3] - 2021-10-22

### Fixed
- Javascript dependency update for several UI kit fixes
- Only prune telescope if telescope in use

## [3.3.2] - 2021-10-19

### Fixed
- Activities on admin side obeying activity for

## [3.3.1] - 2021-10-19

### Fixed
- Error page does not show for admins
- Updated first party packages to fix UI and other errors

## [3.3.0] - 2021-10-18

### Added
- Ability to delete and restore activities & module instances

### Changed
- Redesign of the public-facing site using a UI kit

### Fixed
- When a resource is deleted, you can't then access any pages with that resource on

## [3.2.1] - 2021-08-15

### Updated
- Update composer dependencies to stable versions

## [3.2.0] - 2021-08-14

### Updated
- portal-294: Update to Laravel version 8

### Added
- portal-224: Support for Laravel Sail
- Support for SDK 5

### Removed
- portal-157: Removed config/portal.php
- portal-156: Removed config/laravel-page-speed.php
- Remove `siteSetting` function

## [3.1.6] - 2021-03-20

### Fixed
- portal-332: Update typeform dependency

## [3.1.5] - 2021-03-20

### Fixed
- portal-331: Can't set connection if not set during module creation

### Changed
- Added faker to `require` rather than `require-dev`

## [3.1.4] - 2021-03-10

### Changed
- portal-322: Update to Laravel Tinker v2.0
- portal-323: Updated to use UnionCloud v1.0.2

### Added
- portal-324: Run the UnionCloud sync command daily at 6pm

## [3.1.3] - 2021-03-10

### Added
- portal-320: Vapor UI
- portal-284: Add larabug

### Fixed
- portal-321: Connection sometimes can't be changed

## [3.1.2] - 2021-03-09

### Added
- Updated UnionCloud from v1.0.0 to v1.0.1. Includes portal-315 and portal-316

## [3.1.1] - 2021-03-06

### Added
- UnionCloud scheduled commands run every minute
- portal-305: Stop typeform throwing exception when form ID is null during webhook sync

### Removed
- Remove the unused unioncloud command runner

## [3.1.0] - 2021-03-06

### Changed
- AirTable integration updated to v2.0.0, changed control configuration to match new schema.

[Unreleased]: https://github.com/bristol-su/portal/compare/v3.2.1...HEAD
[3.2.1]: https://github.com/bristol-su/portal/compare/v3.2.0...v3.2.1
[3.2.0]: https://github.com/bristol-su/portal/compare/v3.1.6...v3.2.0
[3.1.6]: https://github.com/bristol-su/portal/compare/v3.1.5...v3.1.6
[3.1.5]: https://github.com/bristol-su/portal/compare/v3.1.4...v3.1.5
[3.1.4]: https://github.com/bristol-su/portal/compare/v3.1.3...v3.1.4
[3.1.3]: https://github.com/bristol-su/portal/compare/v3.1.2...v3.1.3
[3.1.2]: https://github.com/bristol-su/portal/compare/v3.1.1...v3.1.2
[3.1.1]: https://github.com/bristol-su/portal/compare/v3.1.0...v3.1.1
[3.1.0]: https://github.com/bristol-su/portal/releases/tag/v3.1.0

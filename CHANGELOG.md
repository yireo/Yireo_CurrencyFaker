# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.2] - 25 November 2026
### Fixed
- Fake currency rates could overwrite real rates on a live shop via the admin Import button or the scheduled import; rates are now only generated in developer mode, unless `yireo_currency_faker/allow_production` is set in `app/etc/env.php` (the import then reports an error instead of saving rates)
- Add missing dependency `magento/module-directory` and replace the wildcard `magento/framework` constraint

### Changed
- Support PHP 8.2 up to 8.5 (PHP 8.1 is dropped)
- README now describes usage and installing the module as a development-only dependency

## [1.0.1] - 22 October 2025
### Fixed
- Add 8.4

## [0.0.1] - 04 April 2025
### Added
- Initial release
# Yireo_CurrencyFaker

<!-- badges.specs.start -->
![Magento version](https://img.shields.io/badge/Magento-2.4.6%20%7C%202.4.9-orange)
![PHP version](https://img.shields.io/badge/PHP-8.2%E2%80%938.5-777BB4)
![License](https://img.shields.io/badge/License-OSL--3.0-blue)
![Latest Version](https://img.shields.io/packagist/v/yireo/magento2-currency-faker)
<!-- badges.specs.end -->


**This Magento 2 module adds a currency rate import service "Yireo Faker" that generates random currency rates (between 0.5 and 1.5) for testing purposes.**

> [!WARNING]
> This module is meant for development and testing only. Do not use it on a live shop: it overwrites real currency rates with random values.

### Installation
```bash
composer require --dev yireo/magento2-currency-faker
bin/magento module:enable Yireo_CurrencyFaker
```

### Usage
Select **Yireo Faker** as import service under **Stores > Currency Rates** (button **Import**) or under **Stores > Configuration > General > Currency Setup > Scheduled Import Settings**.

Fake rates are only generated in developer mode. In any other deploy mode, the import is refused with a warning and no rates are saved. To allow fake rates outside of developer mode anyway (for instance on a CI or staging environment running in production mode), add the following to `app/etc/env.php`:

```php
'yireo_currency_faker' => [
    'allow_production' => true,
],
```
## Current status

<!-- badges.test.start -->
![Static Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_CurrencyFaker/static-tests.yml?label=static-tests)
![Unit Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_CurrencyFaker/unit-tests.yml?label=unit-tests)
![Integration Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_CurrencyFaker/integration-tests.yml?label=integration-tests)
![Playwright](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_CurrencyFaker/playwright.yml?label=playwright)
![DI Compilation](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_CurrencyFaker/compile.yml?label=compile)
<!-- badges.test.end -->

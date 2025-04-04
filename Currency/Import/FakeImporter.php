<?php declare(strict_types=1);

namespace Yireo\CurrencyFaker\Currency\Import;

use Magento\Directory\Model\Currency\Import\AbstractImport;

class FakeImporter extends AbstractImport
{
    protected function _convert($currencyFrom, $currencyTo)
    {
        return rand(500, 1500) / 1000;
    }
}

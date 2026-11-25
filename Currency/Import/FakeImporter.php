<?php declare(strict_types=1);

namespace Yireo\CurrencyFaker\Currency\Import;

use Magento\Directory\Model\Currency\Import\AbstractImport;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\State;

class FakeImporter extends AbstractImport
{
    public const CONFIG_PATH_ALLOW_PRODUCTION = 'yireo_currency_faker/allow_production';

    public function __construct(
        CurrencyFactory $currencyFactory,
        private readonly State $appState,
        private readonly DeploymentConfig $deploymentConfig
    ) {
        parent::__construct($currencyFactory);
    }

    /**
     * @return array<string, array<string, float|int>>
     */
    public function fetchRates(): array
    {
        if (false === $this->isAllowed()) {
            $this->_messages[] = (string)__(
                'Yireo_CurrencyFaker only generates fake currency rates in developer mode. '
                . 'Set "%1" in app/etc/env.php to allow it in other modes.',
                self::CONFIG_PATH_ALLOW_PRODUCTION
            );

            return [];
        }

        return parent::fetchRates();
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float
     */
    protected function _convert($currencyFrom, $currencyTo): float
    {
        return random_int(500, 1500) / 1000;
    }

    private function isAllowed(): bool
    {
        if ($this->appState->getMode() === State::MODE_DEVELOPER) {
            return true;
        }

        return (bool)$this->deploymentConfig->get(self::CONFIG_PATH_ALLOW_PRODUCTION);
    }
}

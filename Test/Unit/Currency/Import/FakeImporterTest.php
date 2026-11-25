<?php declare(strict_types=1);

namespace Yireo\CurrencyFaker\Test\Unit\Currency\Import;

use Magento\Directory\Model\Currency;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\State;
use PHPUnit\Framework\TestCase;
use Yireo\CurrencyFaker\Currency\Import\FakeImporter;

class FakeImporterTest extends TestCase
{
    public function testFetchRatesInDeveloperMode(): void
    {
        $importer = $this->getImporter(State::MODE_DEVELOPER, null);
        $rates = $importer->fetchRates();

        $this->assertSame(['EUR', 'USD'], array_keys($rates));
        $this->assertSame(1, $rates['EUR']['EUR']);
        $this->assertSame(1, $rates['USD']['USD']);
        $this->assertGreaterThanOrEqual(0.5, $rates['EUR']['USD']);
        $this->assertLessThanOrEqual(1.5, $rates['EUR']['USD']);
        $this->assertSame([], $importer->getMessages());
    }

    public function testFetchRatesBlockedInProductionMode(): void
    {
        $importer = $this->getImporter(State::MODE_PRODUCTION, null);

        $this->assertSame([], $importer->fetchRates());
        $this->assertCount(1, $importer->getMessages());
    }

    public function testFetchRatesBlockedInDefaultMode(): void
    {
        $importer = $this->getImporter(State::MODE_DEFAULT, false);

        $this->assertSame([], $importer->fetchRates());
        $this->assertCount(1, $importer->getMessages());
    }

    public function testFetchRatesAllowedInProductionModeWithFlag(): void
    {
        $importer = $this->getImporter(State::MODE_PRODUCTION, true);

        $this->assertCount(2, $importer->fetchRates());
        $this->assertSame([], $importer->getMessages());
    }

    private function getImporter(string $mode, ?bool $allowProduction): FakeImporter
    {
        $currency = $this->createMock(Currency::class);
        $currency->method('getConfigAllowCurrencies')->willReturn(['EUR', 'USD']);
        $currency->method('getConfigBaseCurrencies')->willReturn(['EUR', 'USD']);

        $currencyFactory = $this->createMock(CurrencyFactory::class);
        $currencyFactory->method('create')->willReturn($currency);

        $state = $this->createMock(State::class);
        $state->method('getMode')->willReturn($mode);

        $deploymentConfig = $this->createMock(DeploymentConfig::class);
        $deploymentConfig->method('get')
            ->with(FakeImporter::CONFIG_PATH_ALLOW_PRODUCTION)
            ->willReturn($allowProduction);

        return new FakeImporter($currencyFactory, $state, $deploymentConfig);
    }
}

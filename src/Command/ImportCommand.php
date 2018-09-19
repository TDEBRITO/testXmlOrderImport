<?php

namespace App\Command;

use App\Entity\ExchangeRate;
use App\Entity\CustomerOrder;
use App\Entity\Product;
use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class ImportCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var ExchangeRateRepository
     */
    private $exchangeRateRepository;

    public function __construct(
        $name = null,
        EntityManagerInterface $em,
        ExchangeRateRepository $exchangeRateRepository
    ) {
        parent::__construct($name);

        $this->em = $em;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    protected function configure()
    {
        $this
            ->setName('app:write:data')

            ->setDescription('Import from xml')

            ->setHelp('This command allows to import all data from xml...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $orderFiles = $finder->files()->in(__DIR__.'/../../ImportFiles')->name('orders*');
        $finder = new Finder();
        $exchangeRateFiles = $finder->files()->in(__DIR__.'/../../ImportFiles')->name('exchangeRates*');
        foreach ($exchangeRateFiles as $file) {
            $reader = new \Sabre\Xml\Reader();
            $reader->xml($file->getContents());
            //TODO BETTER XML BREAKDOWN
            $this->extractExchangeRate($reader);
        }

        foreach ($orderFiles as $file) {
            $reader = new \Sabre\Xml\Reader();
            $reader->xml($file->getContents());
            //TODO BETTER XML BREAKDOWN
            $this->extractOrders($reader);
        }
    }

    public function extractExchangeRate($reader)
    {
        foreach ($reader->parse()['value'] as $currency) {
            $currencyName = $currency['value'][0]['value'];
            $currencyCode = $currency['value'][1]['value'];
            foreach ($currency['value'][2]['value'] as $rates) {
                $exchangeRate = new ExchangeRate();
                $exchangeRate->setCurrencyName($currencyName);
                $exchangeRate->setCurrencyCode($currencyCode);
                $exchangeRate->setDate(new \DateTime($rates['attributes']['date']));
                foreach ($rates['value'] as $value) {
                    if ($value['attributes']['code'] == $currencyCode) {
                        continue;
                    }
                    $exchangeRate->setExchangeCurrency($value['attributes']['code']);
                    $exchangeRate->setExchangeValue($value['attributes']['value']);
                }
                $this->em->persist($exchangeRate);
            }
        }
        $this->em->flush();
    }

    public function extractOrders($reader)
    {
        foreach ($reader->parse()['value'] as $orderValues) {
            $currencyCode = $orderValues['value'][1]['value'];
            $orderDate = new \DateTime($orderValues['value'][2]['value']);

            $exchangeRate = $this->exchangeRateRepository->findOneBy(['currencyCode' => $currencyCode, 'date' => $orderDate]);
            $order = new CustomerOrder();

            $order->setCurrency($exchangeRate);
            $order->setDate(new \DateTime());
            $order->setTotal(floatval($orderValues['value'][4]['value']));
            foreach ($orderValues['value'][3]['value'] as $orderProduct) {
                $product = new Product();
                $product->setTitle($orderProduct['attributes']['title']);
                $product->setPrice(floatval($orderProduct['attributes']['price']));
                $this->em->persist($product);
                $order->addProduct($product);
                $this->em->flush();
            }
            $this->em->persist($order);
        }
        $this->em->flush();
    }
}

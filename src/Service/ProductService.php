<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\XmlReaderService;

class ProductService
{
    private $productRepository;
    private $logger;
    private $xmlReader;
    public function __construct(LoggerInterface $logger, ProductRepository $productRepository, XmlReaderService $xmlReader)
    {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
        $this->xmlReader = $xmlReader;
    }

    public function processXmlData($serverXMLFilePath = null, $localXMLFilePath = null, $localCSVFilePath, $fileName = '', $local = true, $download = true, $storage = 'csv')
    {
        try {
            if ($storage == $_ENV['DEFAULT_STORAGE_TYPE']) {
                $this->xmlReader->writeCsv($serverXMLFilePath, $localXMLFilePath, $localCSVFilePath, $fileName, $local, $download);
            } else {
                $data =  $this->xmlReader->getArrayData();
                $this->productRepository->saveProductData($data);
                unset($data);
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}

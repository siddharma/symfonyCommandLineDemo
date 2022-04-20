<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class XmlReaderService
{
    private $logger;
    private $data = array();
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function fileDownloadFromFtpAndStoreOnLocal($serverFilePath = null, $localFilePath = null, $fileName = null)
    {
        if (!file_exists($serverFilePath)) {
            $this->logger->warning('File not exist on ftp server!', []);
            throw new \Exception('File not exist on ftp server!');
        }

        $content = file_get_contents($serverFilePath);
        if (empty($content)) {
            $this->logger->warning('Unable to read file from ftp server', [$serverFilePath, $localFilePath]);
            throw new \Exception('Unable to read file from ftp server');
        }

        $status = file_put_contents($localFilePath, $content);
        if (!$status) {
            $this->logger->warning('Failed to write file', [$serverFilePath, $localFilePath]);
            throw new \Exception('Failed to write file');
        }

        $this->logger->info('File created successfully', [$serverFilePath, $localFilePath]);
        unset($content);
    }

    public function loadXMLFile($path = null)
    {
        $path = !empty($path) ? $path : $_ENV['LOCAL_STORAGE_PATH'];
        $this->xml = simplexml_load_file($path);
    }

    public function getXMLData($path = null)
    {
        $this->loadXMLFile($path);
        return $this->xml;
    }

    public function writeCsv($xmlFilePath = null, $localXMLFilePath = null, $localCSVFilePath = null, $fileName = '', $local = true, $download = true)
    {
        $fileName = !empty($fileName) ? $fileName : $_ENV['DEFAULT_XML_FILE_NAME'];
        $localCSVFilePath = !empty($localCSVFilePath) ? $localCSVFilePath : $_ENV['LOCAL_STORAGE_PATH'] . 'coffee_feed.csv';
        $xmlFilePath = !empty($xmlFilePath) ? $xmlFilePath : $_ENV['FTP_FILE_PATH'];
        $localXMLFilePath = !empty($localXMLFilePath) ? $localXMLFilePath : $_ENV['LOCAL_STORAGE_PATH'] . $fileName;
        if ($local) {
            $xmlFilePath = $_ENV['LOCAL_STORAGE_PATH'] . $fileName;
            $localXMLFilePath = $_ENV['LOCAL_STORAGE_PATH'] . $fileName;
        }

        if ($download == true) {
            if (!file_exists($xmlFilePath)) {
                $xmlFilePath = $_ENV['FTP_FILE_PATH'];
            }
            $this->fileDownloadFromFtpAndStoreOnLocal($xmlFilePath, $localXMLFilePath, $fileName);
        }

        if (!file_exists($localXMLFilePath)) {
            $this->logger->warning('File not exist on ftp server!', []);
            throw new \Exception('File not exist on ftp server!');
        }

        $this->createCSVOnLocal($localXMLFilePath, $localCSVFilePath);
    }

    public function createCSVOnLocal($localXMLFilePath, $localCSVFilePath)
    {

        $this->getXMLData($localXMLFilePath);
        $f = fopen($localCSVFilePath, 'w');
        $this->createCsv($this->xml, $f);
        $status = fclose($f);
        if (!$status) {
            $this->logger->error("Failed to wite csv", [$localCSVFilePath]);
            throw new \Exception("Failed to wite csv");
            return false;
        }

        $this->logger->info("Successfully created CSV file", [$localCSVFilePath]);
    }

    public function createCsv($xml, $f, $headerRow = 0)
    {
        $headerData = [];
        $rowData = [];
        foreach ($xml->children() as $key => $item) {
            $hasChild = (count($item->children()) > 0) ? true : false;
            if (!$hasChild) {
                $headerData[] = $item->getName();
                $rowData[] = $item;
            } else {
                $this->createCsv($item, $f, $headerRow, $headerRow++);
            }
        }
        if ($headerRow === 0) {
            fputcsv($f, $headerData, ',', '"');
        }
        fputcsv($f, $rowData, ',', '"');
        unset($headerData);
        unset($rowData);
    }


    public function getArrayData($xmlFilePath = null, $localFilePath = null, $fileName = null, $local = true, $download = true)
    {
        $fileName = !empty($fileName) ? $fileName : $_ENV['DEFAULT_XML_FILE_NAME'];
        $localCSVFilePath = $_ENV['LOCAL_STORAGE_PATH'] . 'coffee_feed.csv';
        if ($local) {
            $xmlFilePath = !empty($xmlFilePath) ? $xmlFilePath : $_ENV['LOCAL_STORAGE_PATH'];
        } else {
            $xmlFilePath = !empty($xmlFilePath) ? $xmlFilePath : $_ENV['FTP_FILE_PATH'];
        }

        $localXMLFilePath = $xmlFilePath . $fileName;
        if ($download == true && $local == true) {
            $xmlFilePath = $localXMLFilePath;
            if (!file_exists($localXMLFilePath)) {
                $xmlFilePath = $_ENV['FTP_FILE_PATH'];
            }
            $this->fileDownloadFromFtpAndStoreOnLocal($xmlFilePath, $localFilePath, $fileName);
        }

        if (!file_exists($localXMLFilePath)) {
            $this->logger->warning('File not exist on ftp server!', []);
            throw new \Exception('File not exist on ftp server!');
        }

        $this->getXMLData($localXMLFilePath);
        $this->createXmlToArray($this->xml);
        return $this->data;
    }

    private function createXmlToArray($xml, $headerRow = 0)
    {
        $headerData = [];
        $rowData = [];
        foreach ($xml->children() as $key => $item) {
            $hasChild = (count($item->children()) > 0) ? true : false;
            if (!$hasChild) {
                $headerData[] = $item->getName();
                $rowData[] = (string) $item;
            } else {
                $this->createXmlToArray($item, $headerRow++);
            }
        }

        if ($headerRow === 0) {
            array_push($this->data, $headerData);
        }

        array_push($this->data, $rowData);
        unset($headerData);
        unset($rowData);
    }
}

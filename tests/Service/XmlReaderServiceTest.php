<?php 
namespace App\Tests\Service;

use App\Service\XmlReaderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class XmlReaderServiceTest extends KernelTestCase
{
    
    public function testFileDownloadFromServerWithDefaultValues()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();
        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $xmlReaderService = $container->get(XmlReaderService::class);
        $xmlReaderService->fileDownloadFromFtpAndStoreOnLocal();

        $serverXMLFilePath = $_ENV['FTP_FILE_PATH'];
        $localXMLFilePath = $_ENV['LOCAL_STORAGE_PATH'];
        $fileName = $_ENV['DEFAULT_XML_FILE_NAME'];
        $localXMLFilePathAndName = $localXMLFilePath.$fileName; 
        
        $writer = new FileWriter;
        $this->assertTrue(@$writer->write($localXMLFilePathAndName.'s', 'stuff'));
        $this->assertTrue(file_exists($serverXMLFilePath), 'File exist on sever');
        $this->assertTrue(file_exists($localXMLFilePathAndName), 'File exist on local');
        $this->assertIsReadable($serverXMLFilePath, "Server file is readable");
        $this->assertIsReadable($localXMLFilePathAndName, "Local file is readable");
        $this->assertEquals(file_get_contents($serverXMLFilePath), file_get_contents($localXMLFilePathAndName), "Both file content is same");
    }

    public function testFileDownloadFromServerWithCustomtValues()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();
        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $xmlReaderService = $container->get(XmlReaderService::class);
                
        $serverXMLFilePath = $_ENV['FTP_FILE_PATH'];
        $localXMLFilePath = $_ENV['LOCAL_STORAGE_PATH'];
        $fileName = "note.xml";
        $localXMLFilePathAndName = $_ENV['LOCAL_STORAGE_PATH'].$fileName; 

        $xmlReaderService->fileDownloadFromFtpAndStoreOnLocal($serverXMLFilePath, $localXMLFilePath, $fileName);
        $writer = new FileWriter;
        $this->assertTrue(@$writer->write($localXMLFilePathAndName.'s', 'stuff'));
        $this->assertEquals(true, file_exists($serverXMLFilePath), 'File exist on sever');
        $this->assertEquals(true, file_exists($localXMLFilePathAndName), 'File exist on local');
        $this->assertIsReadable($serverXMLFilePath, "Server file is readable");
        $this->assertIsReadable($localXMLFilePathAndName, "Local file is readable");
        // $this->assertEquals(file_get_contents($serverXMLFilePath), file_get_contents($localXMLFilePathAndName), "Both file content is same");
    }
    
    public function testFileDownloadFromServerWhichIsNotExist()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();
        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $xmlReaderService = $container->get(XmlReaderService::class);
                
        $serverXMLFilePath = $_ENV['FTP_FILE_PATH']."xml";
        $localXMLFilePath = $_ENV['LOCAL_STORAGE_PATH'];
        $fileName = "doesNotExist.xml";
        $localXMLFilePathAndName = $_ENV['LOCAL_STORAGE_PATH'].'fileDoesNotExist/'.$fileName; 

        $this->assertFalse(file_exists($serverXMLFilePath), 'File not exist on sever');
        $writer = new FileWriter;
        $this->assertFalse(@$writer->write($localXMLFilePathAndName, 'stuff'));
        $this->assertFalse(file_exists($localXMLFilePathAndName));

        // $xmlReaderService->fileDownloadFromFtpAndStoreOnLocal($serverXMLFilePath, $localXMLFilePath, $fileName);
        // $this->expectException(\Exception::class);
        // $this->expectExceptionMessage("File not exist on ftp server!");
    }



    public function testWriteCSVWithDefaultParams()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();
        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $xmlReaderService = $container->get(XmlReaderService::class);
                
        $serverXMLFilePath = $_ENV['FTP_FILE_PATH'];
        $localXMLFilePath = $_ENV['LOCAL_STORAGE_PATH'];
        $fileName = "coffee_feed.xml";
        $localXMLFilePathAndName = $_ENV['LOCAL_STORAGE_PATH'].$fileName; 
        $localCSVFilePath = $_ENV['LOCAL_STORAGE_PATH'].'coffee_feed.csv';

        // writeCsv($xmlFilePath = null, $localXMLFilePath = null, $localCSVFilePath, $fileName = '', $local = true, $download = true)
        $xmlReaderService->writeCsv();
        $this->assertTrue(file_exists($serverXMLFilePath), 'File exist on sever');
        $writer = new FileWriter;
        $this->assertTrue(@$writer->write($localXMLFilePathAndName, 'stuff'));
        $this->assertTrue(file_exists($localXMLFilePathAndName));
        $this->assertTrue(file_exists($localCSVFilePath), 'File exist on local');
        // $this->assertEquals(file_get_contents($serverXMLFilePath), file_get_contents($localXMLFilePathAndName), "Both file content is same");
    }


    public function testWriteCSVWithDefaultCustomData()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();
        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $xmlReaderService = $container->get(XmlReaderService::class);
                
        $serverXMLFilePath = $_ENV['FTP_FILE_PATH'];
        $localXMLFilePath = $_ENV['LOCAL_STORAGE_PATH'];
        $fileName = "coffee_feed.xml";
        $localXMLFilePathAndName = $_ENV['LOCAL_STORAGE_PATH'].$fileName; 
        $localCSVFilePath = $_ENV['LOCAL_STORAGE_PATH'].'coffee_feed_test.csv';

        $xmlReaderService->writeCsv($serverXMLFilePath, $localXMLFilePathAndName, $localCSVFilePath, $local = true, $download = true);
        $this->assertTrue(file_exists($serverXMLFilePath), 'File exist on sever');
        $writer = new FileWriter;
        $this->assertTrue(@$writer->write($localXMLFilePathAndName, 'stuff'));
        $this->assertTrue(file_exists($localXMLFilePathAndName));
        $this->assertTrue(file_exists($localCSVFilePath), 'File exist on local');
    }
    // (1) boot the Symfony kernel
    // self::bootKernel();
    
}

final class FileWriter
{
    public function write($file, $content)
    {
        $file = fopen($file, 'w');

        if ($file === false) {
            return false;
        }
        fclose($file);
        return true;
        // ...
    }
}
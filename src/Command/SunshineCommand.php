<?php 
namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ProductService;
use League\Flysystem\FilesystemOperator;

class SunshineCommand extends Command
{
    protected static $defaultName = 'app:sunshine';
    private $logger;
    public $productService;

    public function __construct(LoggerInterface $logger, ProductService $productService)
    {
        $this->logger = $logger;        
        $this->productService =  $productService; 
        parent::__construct();
    }
    
    public function configure()
    {
        $this->setDescription('Process xml file and store it in DB or in CSV')
            ->setHelp('This command allows you to download, process xml and store it in CSV or DB')
            ->addArgument('serverXMLFilePath', InputArgument::OPTIONAL, 'Xml file path to read file.')
            ->addArgument('localXMLFilePath', InputArgument::OPTIONAL, 'Path to store xml file on local system')
            ->addArgument('localCSVFilePath', InputArgument::OPTIONAL, 'Path to write csv file on local system')
            ->addArgument('fileName', InputArgument::OPTIONAL, 'Xml file name.')
            ->addArgument('isLocal', InputArgument::OPTIONAL, 'Boolean true to read file from local and false to read from server')
            ->addArgument('isDownload', InputArgument::OPTIONAL, 'Boolean true to download file from server')
            ->addArgument('storage', InputArgument::OPTIONAL, 'Default storage type is csv and you can change it to DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{        

            $serverXMLFilePath = !empty($input->getArgument('serverXMLFilePath')) ? $input->getArgument('serverXMLFilePath') : $_ENV['FTP_FILE_PATH'];
            $localXMLFilePath = !empty($input->getArgument('localXMLFilePath'))?$input->getArgument('localXMLFilePath'): $_ENV['LOCAL_STORAGE_PATH'].'coffee_feed.xml';
            $localCSVFilePath = (!empty($input->getArgument('localCSVFilePath'))?$input->getArgument('localCSVFilePath'):$_ENV['LOCAL_STORAGE_PATH']).'coffee_feed.csv';
            $fileName = !empty($input->getArgument('fileName'))?$input->getArgument('fileName'):$_ENV['DEFAULT_XML_FILE_NAME'];
            $isLocal = !empty($input->getArgument('isLocal'))?$input->getArgument('isLocal'):true;
            $isDownload = !empty($input->getArgument('isDownload'))?$input->getArgument('isDownload'):true;
            $isStorageType = !empty($input->getArgument('storage'))?$input->getArgument('storage'):"csv";
            
            $this->productService->processXmlData($serverXMLFilePath, $localXMLFilePath, $localCSVFilePath, $fileName, $isLocal, $isLocal, $isStorageType);
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return Command::FAILURE;
        }                
    }
}
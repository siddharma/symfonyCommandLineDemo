# symfonyCommandLineDemo
Item 1 Step 1: Required PHP 8 and Apache latest

Step 2: Copy folder in htdocs folder of XAMPP

Step 3: cd project_dharmendra_sid

Step 4: Execute composer install command

Step 5: Create database with any name and configure it in both file .env and .env.test file
        DATABASE_URL="mysql://root:@127.0.0.1:3306/symphony?serverVersion=5.7&charset=utf8mb4"

Step 6: Execute command [php bin/console doctrine:migrations:migrate]

Step 7: Execute command [php bin/console app:sunshine] to run the program on php8 shell 

Step 8: It will execute with default values and download and create CSV file on local

Step 9: Store files in local directoy project_dharmendra_sid/var/storage/default/

Step 10: you can pass parameters in sequence below 

        serverXMLFilePath   :  Xml file path to read file

        localXMLFilePath    :   Path to store xml file on local system            
        
        localCSVFilePath    :   Path to write csv file on local system
        
        fileName            :   Xml file name
        
        isLocal             :   Boolean true to read file from local
        
        isDownload          :   Boolean true to download file from server
        
        storage             :   Default storage type is csv and you can change it to DB, If you change it to DB then it will store data in table

Step 11: you can check test cases by executing next command [php bin/phpunit] 

# Index Operatur

Operatur is a libary to help building background processes around workers and queues. 

It also provides an interface for writing workers for different platforms and adapters for 
docker, azure functions, iron.io workers, aws lambda.

To use, create a 'Workers' folder in your application src. Look into tests\App for usage.

## Install

``` bash
composer require index-io/operatur
```

## Azure functions integration

# Create function app
Go to your [Azure portal](https://portal.azure.com), create new function app with "Consumption plan". This app will listen to the storage account
you associate when creating the instance. 

# Deployment config
In your newly created function app, go to "Function app settings", bottom left, then click on "Configure continuous integration". Here set-up your deployment mechanism.

# PHP7 setup
Go to "D:\Program Files (x86)\PHP>", copy all contents from v7.0 to the path "D:\home\site\tools"
``` bash
cd D:\home\site\tools
cp -r "D:\Program Files\PHP\v7.0\." .
```

# Install certificate for SSL (curl)
We will be using the default cacert.pem certificate. First download [Curl Certificate](https://curl.haxx.se/ca/cacert.pem) and put it somewhere in your repository that is being pushed to Azure. Deploy.


# Composer setup
To configure composer we need to connect to the box, using Kudu, and install it manually. Go to "Function app settings" -> "Go to Kudu".

On the Kudu console go to D:\home\site\wwwroot\bin (bin folder might have to be created), and copy paste the following command:
``` bash
cd D:\home\site\wwwroot
mkdir bin
php -r "readfile('https://getcomposer.org/installer');" | php
```

To use composer globally, create a batch script, run the following in wwwroot:
``` bash
echo @php "%~dp0\bin\composer.phar" %*>composer.bat
```

To run composer, go back to wwwroot and run:
``` bash
composer.bat install
```

To use composer install, do:
``` bash
cd D:\home\site\wwwroot 
D:\home\site\tools\php.exe bin\composer.phar install
```



Reference: [Run composer on Kudu](https://sunithamk.wordpress.com/2014/06/18/run-composer-on-kudu-azure-websites/).



## To run

Generate skeleton structure, the -p argument is the folder name of where your app sits, default is 'app' but any custom one can be used
``` bash
vendor/bin/console operatur:skeleton -p app
```

This command will generate the folders and files necessary for the functions you just wrote that can then be deployed through git or other mechanisms. If config or routes paths are not provided then it will use the default ones located at /app/Workers/config.php and /app/Workers/routes.php

``` bash
vendor/bin/console operatur:functions -c sample/config.php  -r sample/routes.php -p azure-functions
```

To remove the generated folders / files use the 'remove' argument:
``` bash
vendor/bin/console operatur:functions remove -c sample/config.php  -r sample/routes.php -p azure-functions
```


## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

In the future.

## Credits

- [Cezar Grigore](https://github.com/grigorecezar)
- [Liviu Nasoi](https://github.com/Liviu92)
- [Tom Jenkins](https://github.com/tomtwo)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

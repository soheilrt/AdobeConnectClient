[![Build Status](https://travis-ci.org/soheilrt/AdobeConnectClient.svg?branch=master)](https://travis-ci.org/soheilrt/AdobeConnectClient)

# Client for Adobe Connect API v9.5.4

PHP library to comunicate with the [Adobe Connect Web Service](https://helpx.adobe.com/adobe-connect/webservices/topics.html).

There are many actions implemented. Some of them are a sequence of actions, like the RecordingPasscode.

# Changelog
* ##### Version 3.1.0
  * Add Sco-shortcuts command
  * set/get unknown properties/attribues with php magic functions ( ```__get()``` , ```__set()``` , ```__call()``` )
  * remove entities fixed attributes(_magic function will do the same thing!_)
  
## Installation ##

The package is available on [Packagist](https://packagist.org/packages/soheilrt/adobe-connect-client). You can install it using [Composer](http://getcomposer.org/)

```bash
$ composer require soheilrt/adobe-connect-client
```

## Whats new?

* **now you can dynamically set/get attributes however you want:**
```php
use AdobeConnectClient\Entities\SCO;

$sco = SCO::instance()->setName('Name')->setType(SCO::TYPE_MEETING)
    ->setAttribute1('custom attribute 1')->setDateBegin(new DateInterval('PT1H'));

$sco=SCO::instance();
$sco->name='Name';
$sco->type="Type";
$sco->attribute1="custom attribute 1";
$sco->dateBegin=New DateInterval("PT1H");
```
Since attribtues store on a protected property named ```attributes``` and setting/getting attributes are done via 
php magic functions, you can set or get attribute with any way you're more comfortable.
<br>**Note:** Sience Attributes converted in camelCaseForm and then save, 
you want to more careful about attirbutes Names specially between TWO words in attribute name.
```php
//these actions are doing the same action
//save given data with name classAttirbute in attributes property in class
$sco=SCO::instance();
$sco->setclassAttribute("value 1");
$sco->setClassAttribute("value 2");
$sco->ClassAttribute="value 3";
$sco->class_attribute="value 4";

//save data in class's `attributes` property with the name `classattribute`
$sco->classattribute="data 5";
$sco->Classaatribute="data 6";
```   
since setting attributes via magic function will return class intance, you can add attributes to the class with chains.
  ```php
  //these actions are doing the same action
  //save given data with name classAttirbute in attributes property in class
  $sco=SCO::instance()->setclassAttribute1("value 1")
  ->setClassAttribute2("value 2")->ClassAttribute3("value 3")
  ->setclass_attribute4("value 4");
  
  //save data in class's `attributes` property with the name `classattribute`
  $sco->classattribute="data 5";
  $sco->Classaatribute="data 6";
  ``` 

## Usage

```php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;

$connection = new Connection('https://hostname.adobeconnect.com');
$client =  new Client($connection);
$commonInfo = $client->commonInfo();
```

You can use filters and sorters in some actions.

```php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;
use AdobeConnectClient\Entities\SCO;
use AdobeConnectClient\Filter;
use AdobeConnectClient\Sorter;

$connection = new Connection('https://hostname.adobeconnect.com');
$client =  new Client($connection);

$client->login('username', 'password');

$folderId = 123;

$filter = Filter::instance()
  ->dateAfter('dateBegin', new DateTimeImmutable())
  ->like('name', 'ClassRoom');

$sorter = Sorter::instance()
  ->asc('dateBegin');

$scos = $client->scoContents($folderId, $filter, $sorter);
```

The entities, filters and sorter use Fluent Interface.

The **AdobeConnectClient\Connection\Curl\Connection** class accept an array of options
to configure the CURL.

```php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;

// For tests with no SSL
$connection = new Connection(
  'https://hostname.adobeconnect.com',
  [
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
  ]
);
$client =  new Client($connection);
$commonInfo = $client->commonInfo();
```

### IMPORTANT ###

All Client actions are throwable.

```php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;
use AdobeConnectClient\Exceptions\NoAccessException;

$connection = new Connection('https://hostname.adobeconnect.com');
$client = new Client($connection);

// Throws NoAccessException if not logged in
$client->scoInfo(123);
```

***

- [License](LICENSE)

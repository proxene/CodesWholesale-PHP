# CodesWholesale PHP SDK (V3)

<br/>

[![GitHub Issues](https://img.shields.io/github/issues/proxene/CodesWholesale-PHP.svg?style=for-the-badge)](https://github.com/proxene/CodesWholesale-PHP/issues)
[![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](#)

<br/>

A simple and lightweight PHP SDK for interacting with the **CodesWholesale API V3**.  
Designed in an **object-oriented style** inspired by the V2 SDK, with support for:

<br/>

## Features

- **Authentication & Token Management**
  - Automatic OAuth2 client credentials flow.
  - Token storage via session or custom storage implementation.
  - Automatic token renewal when expired.

- **Product Management**
  - Fetch all products with optional callback handling for large datasets.
  - Retrieve specific products by ID.
  - Access product codes (text or image) through structured objects.

- **Order Management**
  - Create new orders with multiple products.
  - Retrieve orders and their status.
  - Access ordered products as structured objects with codes.

- **Clean, Extensible Architecture**
  - Namespaced classes under `CodesWholesale\Resource` and `CodesWholesale\Storage`.
  - Client class handles all HTTP requests and authentication.
  - Fully object-oriented with typed properties and methods.
  - Exception handling for HTTP and authentication errors.

<br/>

## Requirements

- PHP 7.4+
- cURL extension enabled

<br/>

## Usage

### 1. Initialize the Client

```php

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;
use CodesWholesale\Storage\SessionAuthTokenStorage;
use CodesWholesale\Storage\FileContinuationTokenStorage;

$params = [
    'cw.client_id' => 'your-client-id',
    'cw.client_secret' => 'your-client-secret',
    'cw.endpoint_uri' => CodesWholesale::SANDBOX_ENDPOINT, // or LIVE_ENDPOINT,
    'cw.token_storage' => new SessionAuthTokenStorage()
];

$client = new Client($params);

$continuationStorage = new FileContinuationTokenStorage(__DIR__ . '/last_token.txt');
$continuationToken = $continuationStorage->getContinuationToken();

```

<br/>

### 2. Retrieve Products

```php
use CodesWholesale\Resource\Product;

// Get all products
$products = Product::getAll($client);

// Get a product by ID
$product = Product::getById($client, 'PRODUCT_ID');
```

<details> <summary>Getter list for products</summary>

```php
    $product->getName();
    $product->getPrices();
    $product->getDefaultPrice();
    $product->getStock();
    $product->getPlatform();
    $product->getRegions();
    $product->getReleaseDate();
```

</details>


<br/>

### 3. Create an order

```php
use CodesWholesale\Resource\Order;

$createdOrder = Order::createOrder($client, [
    'productId' => '6313677f-5219-47e4-a067-7401f55c5a3a', 'quantity' => 2]
]);
```


<br/>

### 4. Retrieve account details

```php
use CodesWholesale\Resource\Account;

$accountDetails = Account::getCurrent($client);
```

<details> <summary>Getter list for the current account</summary>
  
```php
    $accountDetails->getBalance();
```

</details>

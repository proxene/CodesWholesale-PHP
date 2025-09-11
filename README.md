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
use CodesWholesale\Storage\TokenSessionStorage;

// Initialize the client
$client = new Client([
    'cw.client_id'     => 'your-client-id',
    'cw.client_secret' => 'your-client-secret',
    'cw.endpoint_uri'  => CodesWholesale::SANDBOX_ENDPOINT, // or LIVE_ENDPOINT,
    'cw.token_storage' => new TokenSessionStorage(),
]);
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
  $product->getDefaultPrices();
  $product->getStock();
  $product->getPlatform();
  $product->getRegions();
```

</details>

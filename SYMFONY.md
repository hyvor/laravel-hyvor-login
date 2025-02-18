## Installation

### Step 1: Install Internal Library

First, you need the internal library via Composer:

```bash
composer require hyvor/internal

# additional bundles
composer require symfony/security-bundle # needed for authentication
```

### Step 2: Add the Bundle to Your Project

Then, add the bundle to your project:

```php
// config/bundles.php
return [
    // ...
    \Hyvor\Internal\Bundle\src\HyvorInternalBundle::class => ['all' => true],
];
```

## Authentication

### Step 1: Setup Firewall and Access Control

```php
<?php

use Hyvor\Internal\Bundle\Security\HyvorAuthenticator;
use Hyvor\Internal\Bundle\Security\UserRole;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Config\SecurityConfig;

return static function (ContainerBuilder $container, SecurityConfig $security): void {

    $security
        ->firewall('hyvor_auth')
        ->stateless(true)
        ->lazy(true)
        ->customAuthenticators([HyvorAuthenticator::class]);

    $security
        ->accessControl()
        ->path('^/api/console')
        ->roles(UserRole::USER);
        
    # other access control

};
```

## Testing

### Step 1: Faking Authentication

In the base test case, you can fake the authentication:

```php
use Hyvor\Internal\Auth\AuthFake;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // sets the user to a user with ID 1 and other default values
        AuthFake::enableForSymfony($this->getContainer(), ['id' => 1]);
    }
}
```

When calling the APIs in tests, setting the `authsess` cookie to a string value is required.

```php
$this->client->getCookieJar()->set(new Cookie('authsess', 'default'));
$this->client->request('GET', '/api/console/...');
```
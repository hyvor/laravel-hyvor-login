## Installation

### Step 1: Install Internal Library

First, you need the internal library via Composer:

```bash
composer require hyvor/internal
```

### Step 2: Add the Bundle to Your Project

Then, add the bundle to your project:

```php
// config/bundles.php
return [
    // ...
    Hyvor\Internal\Bundle\HyvorInternalBundle::class => ['all' => true],
];
```

## Authentication

Things to know:

- AuthUser class implements Symfony's UserInterface.
- 
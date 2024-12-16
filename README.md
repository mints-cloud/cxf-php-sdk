Auth Trait Usage
-----------
- User Auth Trait is a trait that is used to authenticate users in the application.
- Contact Auth Trait is a trait that is used to authenticate contacts in the application.
- Public Auth Trait is a trait that is used to access public data in the application. 
```php
use Cxf\UserAuthTrait;
use Cxf\ContactAuthTrait;
use Cxf\PublicAuthTrait;
```
Cxf User, Contact and Public Usage
-----------
```php
// User Login
$this->initializeUserClient();
$this->mintsUserLogin('email', 'password');
$response = $this->mintsUser->getContacts(); // get contacts

// Contact Login
$this->initializeContactClient();
$this->mintsContactLogin('email', 'password');
$response = $this->mintsContact->getOrders(); // get orders

// Public trait usage
$this->initializePublicClient();
$response = $this->mintsPublic->getStoryVersions(null, false); // get story versions
```
Proxy Usage
-----------
```php // Proxy Routes
Route::any('api/user/v1/{any}', [ProxyController::class, 'proxyRequest'])->where('any', '.*');
Route::any('api/contact/v1/{any}', [ProxyController::class, 'proxyRequest'])->where('any', '.*');
Route::any('api/v1/{any}', [ProxyController::class, 'proxyRequest'])->where('any', '.*');
```
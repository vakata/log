# vakata\log\Log


## Methods

| Name | Description |
|------|-------------|
|[logToFile](#vakata\log\loglogtofile)|helper function which returns a file storage callback to use with addHandler|
|[setupErrorHandling](#vakata\log\logsetuperrorhandling)|Setup an opinionated uncaught error and exception handling.|
|[addContext](#vakata\log\logaddcontext)|adds more context parameters for future entries|
|[addHandler](#vakata\log\logaddhandler)|add a log handler in order to store the log entry|
|[emergency](#vakata\log\logemergency)|log an emergency|
|[alert](#vakata\log\logalert)|log an alert|
|[critical](#vakata\log\logcritical)|log a cricital event|
|[error](#vakata\log\logerror)|log an error|
|[warning](#vakata\log\logwarning)|log a warning|
|[notice](#vakata\log\lognotice)|log a notice|
|[info](#vakata\log\loginfo)|log an info event|
|[debug](#vakata\log\logdebug)|log a debug message|

---



### vakata\log\Log::logToFile
helper function which returns a file storage callback to use with addHandler  


```php
public static function logToFile (  
    string|null $location  
) : callable    
```

|  | Type | Description |
|-----|-----|-----|
| `$location` | `string`, `null` | where to store the messages, defaults to the default error_log |
|  |  |  |
| `return` | `callable` | a function ready to pass to addHandler |

---


### vakata\log\Log::setupErrorHandling
Setup an opinionated uncaught error and exception handling.  
All notice / deprecated / strict errors are only logged, everything else triggers an exception.  
Exceptions are logged and then an optional handler callable is invoked.

```php
public function setupErrorHandling (  
    callable|null $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$handler` | `callable`, `null` | uncaught exception handler, has a single param - the exception |
|  |  |  |
| `return` | `self` |  |

---


### vakata\log\Log::addContext
adds more context parameters for future entries  


```php
public function addContext (  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$context` | `array` | data to store along with each log entry |

---


### vakata\log\Log::addHandler
add a log handler in order to store the log entry  


```php
public function addHandler (  
    callable $handler,  
    int|null $level  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$handler` | `callable` | a function to execute, wihch receives the message, context & severity of the message |
| `$level` | `int`, `null` | optional bitmask level to invoke the handler for (defaults to ALL) |

---


### vakata\log\Log::emergency
log an emergency  


```php
public function emergency (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::alert
log an alert  


```php
public function alert (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::critical
log a cricital event  


```php
public function critical (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::error
log an error  


```php
public function error (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::warning
log a warning  


```php
public function warning (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::notice
log a notice  


```php
public function notice (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::info
log an info event  


```php
public function info (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


### vakata\log\Log::debug
log a debug message  


```php
public function debug (  
    string|\Exception $message,  
    array $context  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$message` | `string`, `\Exception` | event description |
| `$context` | `array` | event context |

---


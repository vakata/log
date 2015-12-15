# vakata\log\Log


## Methods

| Name | Description |
|------|-------------|
|[__construct](#vakata\log\log__construct)|Create an instance.|
|[addContext](#vakata\log\logaddcontext)|adds more context parameters for future entries|
|[emergency](#vakata\log\logemergency)|log an emergency|
|[alert](#vakata\log\logalert)|log an alert|
|[critical](#vakata\log\logcritical)|log a cricital event|
|[error](#vakata\log\logerror)|log an error|
|[warning](#vakata\log\logwarning)|log a warning|
|[notice](#vakata\log\lognotice)|log a notice|
|[info](#vakata\log\loginfo)|log an info event|
|[debug](#vakata\log\logdebug)|log a debug message|

---



### vakata\log\Log::__construct
Create an instance.  


```php
public function __construct (  
    \bitflag $level,  
    string $location,  
    array $additionalContext  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$level` | `\bitflag` | only levels listed here will be stored (defaults to all) |
| `$location` | `string` | log file location (defaults to ini_get(error_log)) |
| `$additionalContext` | `array` | additional data to store with each entry |

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


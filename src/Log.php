<?php

namespace vakata\log;

class Log implements LogInterface
{
    const EMERGENCY = 1;
    const ALERT = 2;
    const CRITICAL = 4;
    const ERROR = 8;
    const WARNING = 16;
    const NOTICE = 32;
    const INFO = 64;
    const DEBUG = 128;
    const ALL = 255;

    protected $handlers = [];
    protected $additionalContext = [];

    protected function getLevel($severity)
    {
        switch ($severity) {
            case 1:
                return 'emergency';
            case 2:
                return 'alert';
            case 4:
                return 'critical';
            case 8:
                return 'error';
            case 16:
                return 'warning';
            case 32:
                return 'notice';
            case 64:
                return 'info';
            case 128:
                return 'debug';
        }
    }
    protected function log(int $severity, $message, array $context = [])
    {
        $context = array_merge($this->additionalContext, $context);
        $context['isException'] = false;
        if ($message instanceof \Throwable) {
            $context['isException'] = true;
            $context['isInternal'] = ($message instanceof \Error) || ($message instanceof \ErrorException);
            $context['code'] = $message->getCode();
            $context['file'] = $message->getFile();
            $context['line'] = $message->getLine();
            $context['trace'] = explode("\n", trim($message->getTraceAsString(), "\r\n"));
            $message = $message->getMessage();
        }

        $handled = false;
        foreach ($this->handlers as $handler) {
            if ($severity & $handler['level']) {
                $handled = true;
                call_user_func($handler['handler'], $message, $context, $severity, $this->getLevel($severity));
            }
        }
        return $handled;
    }
    /**
     * helper function which returns a file storage callback to use with addHandler
     * @method logToFile
     * @param  string|null $location  where to store the messages, defaults to the default error_log
     * @return callable               a function ready to pass to addHandler
     */
    public static function logToFile(string $location = null) {
        return function ($message, $context, $severity, $level) use ($location) {
            $location = $location !== null ? $location : ini_get('error_log');
            if (!is_dir(dirname($location))) {
                mkdir(dirname($location), 0755, true);
            }
            return (bool)@error_log(
                (
                    date('[d-M-Y H:i:s e] ') .
                    'PHP ' . ucfirst($level) . ': ' .
                    $message . "\n" .
                    json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n"
                ),
                3,
                $location
            );
        };
    }

    /**
     * Setup an opinionated uncaught error and exception handling.
     * All notice / deprecated / strict errors are only logged, everything else triggers an exception. 
     * Exceptions are logged and then an optional handler callable is invoked.
     * @method setupErrorHandling
     * @param  callable|null $handler uncaught exception handler, has a single param - the exception
     * @return self
     */
    public function setupErrorHandling(callable $handler = null)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            // do not touch errors that are not marked for reporting
            if (!($errno & error_reporting())) {
                return true;
            }
            $e = new ErrorException($errstr, $errno, $errno, $errfile, $errline);
            // stop processing for "lightweight" errors
            switch ($errno) {
                case E_NOTICE:
                case E_DEPRECATED:
                case E_STRICT:
                case E_USER_NOTICE:
                case E_USER_DEPRECATED:
                    $this->notice($e);
                    return true;
                case E_WARNING:
                case E_USER_WARNING:
                    $this->warning($e);
                    throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
                default:
                    $this->error($e);
                    throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
            }
        });
        set_exception_handler(function ($e) use ($handler) {
            $this->error($e);
            if ($handler) {
                call_user_func($handler, $e);
            }
        });
        return $this;
    }
    /**
     * adds more context parameters for future entries
     * @method addContext
     * @param  array     $context data to store along with each log entry
     */
    public function addContext(array $context)
    {
        $this->additionalContext = array_merge($this->additionalContext, $context);
        return $this;
    }
    /**
     * add a log handler in order to store the log entry
     * @method addHandler
     * @param  callable   $handler a function to execute, wihch receives the message, context & severity of the message
     * @param  int|null   $level   optional bitmask level to invoke the handler for (defaults to ALL)
     */
    public function addHandler(callable $handler, int $level = null)
    {
        $level = $level !== null ? $level : static::ALL;
        $this->handlers[] = [ 'level' => $level, 'handler' => $handler ];
        return $this;
    }
    /**
     * log an emergency
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function emergency($message, array $context = [])
    {
        return $this->log(static::EMERGENCY, $message, $context);
    }
    /**
     * log an alert
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function alert($message, array $context = [])
    {
        return $this->log(static::ALERT, $message, $context);
    }
    /**
     * log a cricital event
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function critical($message, array $context = [])
    {
        return $this->log(static::CRITICAL, $message, $context);
    }
    /**
     * log an error
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function error($message, array $context = [])
    {
        return $this->log(static::ERROR, $message, $context);
    }
    /**
     * log a warning
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function warning($message, array $context = [])
    {
        return $this->log(static::WARNING, $message, $context);
    }
    /**
     * log a notice
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function notice($message, array $context = [])
    {
        return $this->log(static::NOTICE, $message, $context);
    }
    /**
     * log an info event
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function info($message, array $context = [])
    {
        return $this->log(static::INFO, $message, $context);
    }
    /**
     * log a debug message
     * @method emergency
     * @param  string|\Exception  $message event description
     * @param  array     $context event context
     */
    public function debug($message, array $context = [])
    {
        return $this->log(static::DEBUG, $message, $context);
    }
}

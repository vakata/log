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

    protected $level;
    protected $location;
    protected $additionalContext;

    /**
     * Create an instance.
     * @method __construct
     * @param  bitflag     $level             only levels listed here will be stored (defaults to all)
     * @param  string      $location          log file location (defaults to ini_get(error_log))
     * @param  array       $additionalContext additional data to store with each entry
     */
    public function __construct($level = null, $location = null, array $additionalContext = [])
    {
        $this->level = $level !== null ? $level : static::ALL;
        $this->location = $location ? $location : ini_get('error_log');
        $this->additionalContext = $additionalContext;
    }

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
    protected function log($severity, $message, array $context = [])
    {
        if (!((int) $severity & $this->level)) {
            return true;
        }
        $context = array_merge($this->additionalContext, $context);
        if ($message instanceof \Exception) {
            $context['code'] = $message->getCode();
            $context['file'] = $message->getFile();
            $context['line'] = $message->getLine();
            $context['trace'] = $message->getTrace();
            $message = $message->getMessage();
        }

        if (!is_dir(dirname($this->location))) {
            mkdir(dirname($this->location), 0755, true);
        }
        return (bool)@error_log(
            (
                date('[d-M-Y H:i:s e] ') .
                'PHP ' . ucfirst($this->getLevel($severity)) . ': ' .
                $message . "\n" .
                json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n"
            ),
            3,
            $this->location
        );
    }
    /**
     * adds more context parameters for future entries
     * @method addContext
     * @param  array     $context data to store along with each log entry
     */
    public function addContext($context)
    {
        $this->additionalContext = array_merge($this->additionalContext, $context);
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

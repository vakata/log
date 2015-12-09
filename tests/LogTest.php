<?php
namespace vakata\log\test;

class LogTest extends \PHPUnit_Framework_TestCase
{
	protected static $dir = null;

	public static function setUpBeforeClass() {
	}
	public static function tearDownAfterClass() {
	}
	protected function setUp() {
		self::$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log';
		mkdir(self::$dir, 0755, true);
	}
	protected function tearDown() {
		foreach(scandir(self::$dir) as $file) {
			if (is_file(self::$dir . DIRECTORY_SEPARATOR . $file)) {
				unlink(self::$dir . DIRECTORY_SEPARATOR . $file);
			}
		}
		rmdir(self::$dir);
	}

	public function testCreate() {
		$log = new \vakata\log\Log();
		$this->assertEquals(true, $log instanceof \vakata\Log\LogInterface);
	}
	/**
	 * @depends testCreate
	 */
	public function testDirs() {
		$file = self::$dir . DIRECTORY_SEPARATOR . 'predefined.log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL, $file);
		$log->debug('DEBUG');
		$this->assertEquals(true, strpos(file_get_contents($file), 'DEBUG') > 0);

		$file = self::$dir . DIRECTORY_SEPARATOR . 'default.log';
		ini_set('error_log', $file);
		$log = new \vakata\log\Log();
		$log->debug('DEBUG2');
		$this->assertEquals(true, strpos(file_get_contents($file), 'DEBUG2') > 0);
	}
	/**
	 * @depends testCreate
	 */
	public function testLevels() {
		$file = self::$dir . DIRECTORY_SEPARATOR . 'levels.log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL ^ \vakata\log\Log::DEBUG, $file);
		$this->assertEquals(true, $log->debug('DEBUG'));
		$this->assertEquals(false, is_file($file));

		foreach ([ 'emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info' ] as $k => $level) {
			$log->{$level}('MESS_' . $level, [ 'index' => 'index_' . $k ]);
			$this->assertEquals(true, strpos(file_get_contents($file), 'MESS_' . $level) > 0);
			$this->assertEquals(true, strpos(file_get_contents($file), 'index_' . $k) > 0);
		}
	}
	/**
	 * @depends testCreate
	 */
	public function testContext() {
		$file = self::$dir . DIRECTORY_SEPARATOR . 'context.log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL, $file, ['context' => 'sample_context']);
		$this->assertEquals(true, $log->debug('DEBUG'));
		$this->assertEquals(true, strpos(file_get_contents($file), 'sample_context') > 0);
		$log->addContext([ 'more' => 'more_context' ]);
		$this->assertEquals(true, $log->debug('DEBUG'));
		$this->assertEquals(true, strpos(file_get_contents($file), 'more_context') > 0);
	}
	/**
	 * @depends testCreate
	 */
	public function testException() {
		$file = self::$dir . DIRECTORY_SEPARATOR . 'exception.log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL, $file, ['context' => 'sample_context']);
		try {
			throw new \Exception('test_exception');
		}
		catch(\Exception $e) {
			$log->debug($e);
		}
		$this->assertEquals(true, strpos(file_get_contents($file), 'test_exception') > 0);
	}
}

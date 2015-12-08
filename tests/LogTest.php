<?php
namespace vakata\log\test;

class LogTest extends \PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass() {
	}
	public static function tearDownAfterClass() {
	}
	protected function setUp() {
	}
	protected function tearDown() {
	}

	public function testCreate() {
		$log = new \vakata\log\Log();
		$this->assertEquals(true, $log instanceof \vakata\Log\LogInterface);
	}
	/**
	 * @depends testCreate
	 */
	public function testDirs() {
		$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log1';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL, $dir);
		$log->debug('DEBUG');
		$this->assertEquals(true, strpos(file_get_contents($dir . '/debug.log'), 'DEBUG') > 0);
		unlink($dir . '/debug.log');
		rmdir($dir);

		$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log2' . DIRECTORY_SEPARATOR . 'test.log';
		ini_set('error_log', $dir);
		$log = new \vakata\log\Log();
		$log->debug('DEBUG2');
		$this->assertEquals(true, strpos(file_get_contents(dirname($dir) . '/debug.log'), 'DEBUG2') > 0);
		unlink(dirname($dir) . '/debug.log');
		rmdir(dirname($dir));

		ini_set('error_log', '');
		$log = new \vakata\log\Log();
		$log->debug('DEBUG3');
		$this->assertEquals(true, strpos(file_get_contents(getcwd() . '/debug.log'), 'DEBUG3') > 0);
		unlink(getcwd() . '/debug.log');
	}
	/**
	 * @depends testCreate
	 */
	public function testLevels() {
		$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL ^ \vakata\log\Log::DEBUG, $dir);
		$this->assertEquals(true, $log->debug('DEBUG'));
		$this->assertEquals(false, is_file($dir . '/debug.log'));

		foreach ([ 'emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info' ] as $k => $level) {
			$log->{$level}('MESS_' . $level, [ 'index' => 'index_' . $k ]);
			$this->assertEquals(true, strpos(file_get_contents($dir . '/'.$level.'.log'), 'MESS_' . $level) > 0);
			$this->assertEquals(true, strpos(file_get_contents($dir . '/'.$level.'.log'), 'index_' . $k) > 0);
			unlink($dir . '/' . $level . '.log');
		}
		rmdir($dir);
	}
	/**
	 * @depends testCreate
	 */
	public function testContext() {
		$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL, $dir, ['context' => 'sample_context']);
		$this->assertEquals(true, $log->debug('DEBUG'));
		$this->assertEquals(true, strpos(file_get_contents($dir . '/debug.log'), 'sample_context') > 0);
		$log->addContext([ 'more' => 'more_context' ]);
		$this->assertEquals(true, $log->debug('DEBUG'));
		$this->assertEquals(true, strpos(file_get_contents($dir . '/debug.log'), 'more_context') > 0);
		unlink($dir . '/debug.log');
		rmdir($dir);
	}
	/**
	 * @depends testCreate
	 */
	public function testException() {
		$dir = __DIR__ . DIRECTORY_SEPARATOR . 'log';
		$log = new \vakata\log\Log(\vakata\log\Log::ALL, $dir, ['context' => 'sample_context']);
		try {
			throw new \Exception('test_exception');
		}
		catch(\Exception $e) {
			$log->debug($e);
		}
		$this->assertEquals(true, strpos(file_get_contents($dir . '/debug.log'), 'test_exception') > 0);
		unlink($dir . '/debug.log');
		rmdir($dir);
	}
}

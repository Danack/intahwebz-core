<?php


namespace Intahwebz\Cache\Tests;

use Intahwebz\Cache\APCObjectCache;

class APCObjectCacheTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var APCObjectCache
     */
    private $apcObjectCache;

	protected function setUp(){
        if (extension_loaded('apc') == false) {
            $this->markTestSkipped(
                'The APC extension is not available.'
            );
            return;
        }

        if (ini_get('apc.enable_cli') != 1) {
            throw new \Exception("apc.enable_cli is not enabled. This is required to be enabled.");
        }

        apc_clear_cache('user');
        $this->apcObjectCache = new APCObjectCache();
	}

	protected function tearDown(){
        apc_clear_cache('user');
	}

    function testPut(){
        $this->apcObjectCache->put('test', 'value');
    }

    function testGet(){
        $srcValue = '12345';
        $keyName = 'orly';
        $this->apcObjectCache->put($keyName, $srcValue);
        $value = $this->apcObjectCache->get($keyName);
        $this->assertEquals($srcValue, $value);
    }

    function testClear(){
        $this->apcObjectCache->put('test', 'value');
        $this->apcObjectCache->clear('test');
        $value = $this->apcObjectCache->get('test');
        $this->assertNull($value);
    }
}


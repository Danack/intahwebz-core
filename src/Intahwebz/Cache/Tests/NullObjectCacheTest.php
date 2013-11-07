<?php


namespace Intahwebz\Cache\Tests;


//use Intahwebz\PHPTemplate\Converter;
//use Intahwebz\PHPTemplate\PHPTemplateBase;
////use Intahwebz\Tests\PHPTemplate\PlaceHolderView;
//use Intahwebz\PHPTemplate\Tests\PlaceHolderView;
//use Intahwebz\PHPTemplate\Converter\PHPTemplateConverter;
//use Intahwebz\PHPTemplate\Tests\PHPTemplateTestException;


use Intahwebz\Cache\NullObjectCache;

class NullObjectCacheTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var NullObjectCache
     */
    private $nullCache;

	protected function setUp(){
        $this->nullCache = new NullObjectCache();
	}

//	protected function tearDown(){
//  //      ob_end_clean();
//	}


    function testPut(){
        $this->nullCache->put('test', 'value');
    }

    function testGet(){
        $this->nullCache->put('test', 'value');
        $value = $this->nullCache->get('test');

        $this->assertNull($value);
    }

    function testClear(){
        $this->nullCache->put('test', 'value');
        $this->nullCache->clear('test');
        $value = $this->nullCache->get('test');
        $this->assertNull($value);
    }
}


<?php
namespace JsonSchemaValidation;

class UnitTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new \Silex\Application(['debug' => true]);
        $this->app->register(new SilexServiceProvider, ['jsonschemas' => [
            'notfound' => __DIR__ . 'notfound.json',
            'found' => __DIR__ . '/unittest.json',
        ]]);
        $this->app->boot();
    }

    public function test_schema_not_found()
    {
        $this->setExpectedException(\JsonSchema\Exception\ResourceNotFoundException::class);
        $this->app['jsonschema']['notfound']->validate((object)[]);
    }

    public function test_schema_not_validate()
    {
        $this->setExpectedException(ValidationException::class);
        $this->app['jsonschema']['found']->validate((object)["notvalid"=>"123"]);
    }

    public function test_schema_validate()
    {
        $validate = $this->app['jsonschema']['found']->validate((object)["test"=>"valid"]);
        $this->assertTrue($validate);
    }
}

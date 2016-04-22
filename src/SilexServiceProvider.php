<?php
namespace JsonSchemaValidation;

class SilexServiceProvider implements \Silex\ServiceProviderInterface
{
    public function register(\Silex\Application $app)
    {
        $app['jsonschema'] = $app->share(function($app) {
            $schemas = [];

            $schemas = new \Pimple();
            foreach ($app['jsonschemas'] as $name => $path) {
                $schemas[$name] = $app->share(function($schemas) use ($path) {
                    return new Service($path);
                });
            }
            return $schemas;
        });
    }

    public function boot(\Silex\Application $app)
    {
    }
}

<?php

namespace AhmedHegazy\FcmHelper\Tests;

use AhmedHegazy\FcmHelper\FcmHelperServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'AhmedHegazy\\FcmHelper\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FcmHelperServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_fcm-helper_table.php.stub';
        $migration->up();
        */
    }

    /**
     * Call protected/private method of a class.
     *
     * @param  string|object  $object  Object or classname
     * @param  string  $methodName  Method name to call
     * @param  array  $parameters  Array of parameters to pass into method.
     * @return mixed Method return.
     */
    protected function invokePrivateMethod($object, string $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(is_string($object) ? $object : get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(is_string($object) ? null : $object, $parameters);
    }
}

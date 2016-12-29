<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    protected $app;

    public function createApp() {

        // load values from .env, use env() to retrieve them
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..', '.testenv');
        $dotenv->load();

        require __DIR__ . '/../../src/helpers.php';

        // Use the application settings
        $settings = require __DIR__ . '/../../src/settings.php';

        // Instantiate the application
        $this->app = $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../../src/dependencies.php';

        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../../src/middleware.php';
        }

        // Register routes
        require __DIR__ . '/../../src/routes.php';
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Process the application
        $response = $this->app->process($request, $response);

        // Return the response
        return $response;
    }

    protected function beginTransaction() {
        $this->app->getContainer()['db']->getDatabaseManager()->beginTransaction();
    }

    protected function rollback() {
        $this->app->getContainer()['db']->getDatabaseManager()->rollback();
    }

    protected function createTestUser() {
        return $this->runApp('POST', '/api/v1/user', [
            'mailaddress' => 'test@mail.com',
            'password' => 'testpw',
        ]);
    }
}

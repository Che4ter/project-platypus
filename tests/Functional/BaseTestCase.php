<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Platypus\Model\User;

define('DEFAULT_TESTUSER_EMAIL', 'test@stud.hslu.ch');
define('DEFAULT_TESTUSER_PASSWORD', '12345678');

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

    protected $settings;

    public function createApp() {

        // load values from .env, use env() to retrieve them
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..', '.testenv');
        $dotenv->load();

        require __DIR__ . '/../../src/helpers.php';

        // Use the application settings
        $this->settings = $settings = require __DIR__ . '/../../src/settings.php';

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

    private function createAppRequest($requestMethod, $requestUri, $requestData = null, $requestToken = null) {
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

        // send authentication token if available
        if (isset($requestToken)) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $requestToken);
        }

        return $request;
    }

    private function processRequest($request) {
        // Set up a response object
        $response = new Response();

        // Process the application
        $response = $this->app->process($request, $response);

        // Return the response
        return $response;
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
        $request = $this->createAppRequest($requestMethod, $requestUri, $requestData);
        return $this->processRequest($request);
    }

    public function runAppAs($user, $requestMethod, $requestUri, $requestData = null)
    {
        $request = $this->createAppRequest($requestMethod, $requestUri, $requestData, $user->token);
        return $this->processRequest($request);
    }

    protected function beginTransaction() {
        $this->app->getContainer()['db']->getDatabaseManager()->beginTransaction();
    }

    protected function rollback() {
        $this->app->getContainer()['db']->getDatabaseManager()->rollback();
    }

    protected function makeCreateTestUserRequest($email = null, $password = null) {
        if($email === null) $email = DEFAULT_TESTUSER_EMAIL;
        if($password === null) $password = DEFAULT_TESTUSER_PASSWORD;

        return $this->runApp('POST', '/api/v1/user', [
            'mailaddress' => $email,
            'password' => $password,
        ]);

    }

    protected function createTestUser($email = null, $password = null, $role_id = 1) {
        $this->assertTrue($role_id > 0, "role_id must be greater than 0 for creating a test user");
        $response = $this->makeCreateTestUserRequest($email, $password);
        $this->assertEquals(200, $response->getStatusCode(), "User registration is broken for test users!");
        $json_body = json_decode($response->getBody());
        $this->assertTrue(is_object($json_body), "Invalid JSON returned for user regisration of a test user!");
        if($role_id > 1) {
            $user = User::where('mailaddress', $email)->first();
            $user->role_id = $role_id;
            $this->assertTrue($user->save(), "Couldn't save test user with role_id > 1 (not the default)");
        }
        return $json_body->new_user;
    }

    protected function aquireAuthTokenForUser($email, $password) {
        $response = $this->runApp('POST', '/api/v1/auth/token', [
            'mailaddress' => $email,
            'password' => $password
        ]);

        $this->assertEquals(201, $response->getStatusCode(), "Couldn't aquire auth token for test user");
        $json_body = json_decode($response->getBody());
        $this->assertTrue(is_object($json_body), "Invalid JSON returned for authentication of a test user");
        return $json_body->token;
    }

    protected function createAuthenticatedTestUser($email = null, $password = null, $role_id = 1) {
        if($email === null) $email = DEFAULT_TESTUSER_EMAIL;
        if($password === null) $password = DEFAULT_TESTUSER_PASSWORD;

        $user = $this->createTestUser($email, $password, $role_id);
        $user->token = $this->aquireAuthTokenForUser($email, $password);
        return $user;
    }
}

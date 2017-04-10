<?php

namespace Tests\Leos\UI\Behat\Context\Api;

use Behat\Behat\Context\Context;
use GuzzleHttp\Client as Http;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;

use Psr\Http\Message\ResponseInterface;

use Lakion\ApiTestCase\JsonApiTestCase;

use Coduo\PHPMatcher\Matcher\Matcher;
use Coduo\PHPMatcher\Factory\SimpleFactory;

use Behat\Gherkin\Node\PyStringNode;

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

/**
 * Class ApiContext
 *
 * @package Tests\Leos\Leos\UI\Behat\Context\Api
 */
class ApiContext extends JsonApiTestCase implements Context
{
    const
        FIXTURES = '/tests/UI/Fixtures',
        RESPONSES = '/tests/UI/Responses/'
    ;

    /**
     * @var Http
     */
    private $http;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var Matcher
     */
    private $matcher;

    /**
     * @var HttpFoundationFactory
     */
    private $httpFoundationFactory;

    /**
     * @var array
     */
    private $placeholders = [];

    /**
     * ApiContext constructor.
     *
     * @param string $path
     * @param string $basePath
     * @param string $responsesPath
     * @param string $fixturesPath
     */
    public function __construct(string $path, string $basePath, string $responsesPath = null, string $fixturesPath = null)
    {
        $_SERVER['KERNEL_DIR'] = $basePath . '/app';
        $_SERVER['IS_DOCTRINE_ORM_SUPPORTED'] = true;

        parent::__construct();

        $this->http = new Http([
            // Base URI is used with relative requests
            'base_uri' => $path,
            'timeout'         => 5.0,
            'connect_timeout' => 2.5,
            'content-type' => 'application/json',
        ]);

        $this->dataFixturesPath = $fixturesPath ?: $basePath.self::FIXTURES;
        $this->expectedResponsesPath = $responsesPath ?: $basePath.self::RESPONSES;

        $this->matcher = (new SimpleFactory())->createMatcher();
        $this->httpFoundationFactory = new HttpFoundationFactory();
    }

    public function http(): Http
    {
        return $this->http;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    final protected function placeholders(string $string): string
    {
        foreach($this->placeholders as $key => $value) {

            $string = str_replace('%' . $key . '%', $value, $string);
        }

        return $string;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return ApiContext
     */
    protected function addPlaceHolder(string $key, $value): self
    {
        $this->placeholders[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return ApiContext
     */
    protected function removePlaceHolder(string $key): self
    {
        unset($this->placeholders[$key]);

        return $this;
    }

    /**
     * @return ApiContext
     */
    protected function cleanPlaceHolders(): self
    {
        $this->placeholders = [];

        return $this;
    }

    /**
     * @When /^I send a "([^"]*)" request to "([^"]*)"$/
     *
     * @param $method
     * @param $uri
     */
    public function iSendARequestTo($method, $uri)
    {
        $this->request($method, $uri);
    }

    /**
     * @When /^I send a "([^"]*)" to "([^"]*)" with:$/
     *
     * @param $method
     * @param $uri
     * @param PyStringNode $string
     */
    public function iSendAToWith($method, $uri, PyStringNode $string)
    {
        $this->request($method, $uri, [
            RequestOptions::JSON => json_decode(
                $this->placeholders($string->getRaw()),
                true
            )
        ]);

    }

    /**
     * @When /^I send a "([^"]*)" to resource "([^"]*)" with:$/
     *
     * @param $method
     * @param $uri
     * @param PyStringNode $string
     */
    public function iSendAToResourceWith($method, $uri, PyStringNode $string)
    {
        $this->request($method, $this->resource . $uri, [
            RequestOptions::JSON => json_decode($string->getRaw(), true)
        ]);
    }

    /**
     * @When /^I request again the resource$/
     */
    public function iRequestAgainResource()
    {
        $this->request('GET', $this->resource);
    }

    /**
     * @When /^I send a "([^"]*)" to the resource with:$/
     *
     * @param $method
     * @param PyStringNode $string
     */
    public function iSendAToTheResourceWith($method, PyStringNode $string)
    {
        $this->request($method, $this->resource, [
            RequestOptions::JSON => json_decode($string->getRaw(), true)
        ]);
    }

    /**
     * @Given /^the response should match with code "([^"]*)" and body:$/
     *
     * @param PyStringNode $expected
     */
    public function theResponseShouldMatchWith(int $code, PyStringNode $expected)
    {
        $this->theResponseCodeIs($code);

        self::assertTrue(
            $this->matcher->match(
                (string) $this->response->getBody(),
                $expected->getRaw()
            ),
            'Response match error'
        );
    }

    /**
     * @Then /^I should be redirected to resource$/
     */
    public function iShouldBeRedirectedToResource()
    {
        self::assertNotNull($this->response->getHeaderLine('location'));

        $this->resource = $this->response->getHeaderLine('location');
        $this->request('GET', $this->resource);
    }

    /**
     * @Given /^the response body match with file "([^"]*)" and status code is "([^"]*)"$/
     *
     * @param string $file
     * @param int $code
     */
    public function theResponseBodyMatchWithFileAndStatusCodeIs(string $file, int $code)
    {
        self::assertResponse(
            $this->httpFoundationFactory->createResponse($this->response),
            $file,
            $code
        );
    }
    
    /**
     * @param string $location
     *
     * @return string
     */
    protected function getResourceIdFromLocation(string $location): string
    {
        return substr($location, strrpos($location, '/')+1);
    }

    /**
     * @Given /^the response code is "([^"]*)"$/
     *
     * @param int $code
     */
    public function theResponseCodeIs(int $code)
    {
        self::assertEquals($this->response->getStatusCode(),$code);
    }

    /**
     * @Given /^a user "([^"]*)" logged with password "([^"]*)"$/
     *
     * @param string $user
     * @param string $pass
     */
    public function aUserLoggedWithPassword(string $user, string $pass)
    {
        $this->request('POST', '/auth/login', [
            RequestOptions::JSON => [
                '_username' => $user,
                '_password' => $pass
            ]
        ]);

        self::assertEquals(200, $this->response->getStatusCode(), 'User cannot be logged due to credentials error');

        $this->options[RequestOptions::HEADERS] = [
            'Authorization' =>  'Bearer ' . json_decode($this->response->getBody(), true)['token']
        ];
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     */
    protected function request(string $method, string $uri, array $options = [])
    {
        try{

            $options = array_merge($this->options, $options);

            $this->response = $this->http->request($method, $uri, $options);

        } catch (ClientException $e) {

            if ($e->hasResponse()) {

                $this->response = $e->getResponse();
            }
        }
    }

}

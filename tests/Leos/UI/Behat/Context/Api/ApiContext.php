<?php

namespace Tests\Leos\UI\Behat\Context\Api;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\RequestException;

use Psr\Http\Message\ResponseInterface;

use Lakion\ApiTestCase\JsonApiTestCase;

use Coduo\PHPMatcher\Matcher\Matcher;
use Coduo\PHPMatcher\Factory\SimpleFactory;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Context\SnippetAcceptingContext;

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

/**
 * Class ApiContext
 * @package Tests\Leos\Leos\UI\Behat\Context\Api
 */
class ApiContext extends JsonApiTestCase implements SnippetAcceptingContext
{

    const
        FIXTURES = '/tests/Leos/UI/Behat/Context/Fixtures',
        RESPONSES = '/tests/Leos/UI/Responses/'
    ;
    /**
     * @var Http
     */
    private $http;

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

    /**
     * @When /^I send a "([^"]*)" request to "([^"]*)"$/
     *
     * @param $method
     * @param $uri
     */
    public function iSendARequestTo($method, $uri)
    {
        try{

            $this->response = $this->http->request($method, $uri);
            
        } catch (ClientException $e) {

            $this->response = $e->getResponse();
        }
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
        try{
            $this->response = $this->http()->request($method, $uri, [
                RequestOptions::JSON => json_decode($string->getRaw(), true)
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {

            }
        }
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
        $this->response = $this->http()->request($method, $this->resource . $uri, [
            RequestOptions::JSON => json_decode($string->getRaw(), true)
        ]);
    }

    /**
     * @When /^I send a "([^"]*)" to the resource with:$/
     *
     * @param $method
     * @param PyStringNode $string
     */
    public function iSendAToTheResourceWith($method, PyStringNode $string)
    {
        try{
            $this->response = $this->http()->request($method, $this->resource, [
                RequestOptions::JSON => json_decode($string->getRaw(), true)
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {

            }
        }
    }
    
    /**
     * @Given /^the response should match with:$/
     *
     * @param PyStringNode $expected
     */
    public function theResponseShouldMatchWith(PyStringNode $expected)
    {
        self::assertTrue(
            $this->matcher->match(
                (string) $this->response->getBody(),
                $expected->getRaw()
            ),
            'Response match error'
        );
    }

    /**
     * @return Http
     */
    public function http(): Http
    {
        return $this->http;
    }

    /**
     * @Then /^I should be redirected to resource$/
     */
    public function iShouldBeRedirectedToResource()
    {
        self::assertNotNull($this->response->getHeaderLine('location'));

        $this->resource = $this->response->getHeaderLine('location');
        $this->response = $this->http()->request('GET', $this->resource);
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
     * @Given /^the response code is "([^"]*)"$/
     *
     * @param int $code
     */
    public function theResponseCodeIs(int $code)
    {
        self::assertEquals($this->response->getStatusCode(),$code);
    }

}

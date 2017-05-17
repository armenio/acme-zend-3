<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace ApiTest\Controller;

define('ROOT_PATH', dirname(dirname(dirname(dirname(__DIR__)))));

use Cake\Datasource\ConnectionManager;
use Zend\Json\Json;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProductsControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        //error_reporting(0);

        //cria a conexão
        if (!ConnectionManager::getConfig('default')) {
            ConnectionManager::setConfig('default', [
                'className' => 'Cake\Database\Connection',
                'driver' => 'Cake\Database\Driver\Mysql',
                'persistent' => false,
                'host' => 'localhost',
                'database' => 'acme',
                'username' => 'username',
                'password' => 'password',
                'timezone' => 'UTC',
                'cacheMetadata' => false,
                'log' => false,
                'quoteIdentifiers' => true,
            ]);
        }

        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    protected function addTokenHeaderLine()
    {
        $headers = $this->getRequest()->getHeaders();
        $headers->addHeaderLine('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0OTQ2NDkxMTQsInN1YiI6MSwiZXhwIjoxNTI2MTg1MTE0fQ.WA1KXgubRIWTIgfR9JvqVUkH523fmPvBMpikSlazb2U');
    }

    protected $productData = [
        'name' => 'Playstation 4',
        'description' => 'Acompanha 1 Jogo',
        'price' => '1299,90',
        'stock' => '10',
    ];

    public function testClearData()
    {
        //limpa os dados do banco
        ConnectionManager::get('default')->query('TRUNCATE TABLE `products`');
        ConnectionManager::get('default')->query('TRUNCATE TABLE `users`');

        $this->assertTrue(true);
    }

    public function test_POST_401()
    {
        //$this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'POST', $this->productData);

        $this->assertResponseStatusCode(401);
    }

    public function test_POST_400()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'POST', [0]);

        $this->assertResponseStatusCode(400);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey('errors', $json);
    }

    public function test_POST_201()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'POST', $this->productData);

        $this->assertResponseStatusCode(201);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey('id', $json);
    }

    public function test_POST_201_2()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'POST', array_merge($this->productData, ['name' => 'Playstation 3']));

        $this->assertResponseStatusCode(201);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey('id', $json);
    }

    public function test_GET_1_401()
    {
        //$this->addTokenHeaderLine();

        $this->dispatch('/api/products/1', 'GET');

        $this->assertResponseStatusCode(401);
    }

    public function test_GET_1_404()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/0', 'GET');

        $this->assertResponseStatusCode(404);
    }

    public function test_GET_1_200()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/1', 'GET');

        $this->assertResponseStatusCode(200);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey('id', $json);
    }

    public function test_GET_401()
    {
        //$this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'GET');

        $this->assertResponseStatusCode(401);
    }

    public function test_GET_200()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'GET');

        $this->assertResponseStatusCode(200);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey(0, $json);
        $this->assertArrayHasKey('id', $json[0]);
    }

    public function test_GET_400()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products', 'GET', ['order' => 'xxx']);

        $this->assertResponseStatusCode(400);
    }

    public function test_PUT_401()
    {
        //$this->addTokenHeaderLine();

        $this->dispatch('/api/products/1', 'PUT', $this->productData);

        $this->assertResponseStatusCode(401);
    }

    public function test_PUT_404()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/0', 'PUT');

        $this->assertResponseStatusCode(404);
    }

    public function test_PUT_400()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/1', 'PUT', [0]);

        $this->assertResponseStatusCode(400);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey('errors', $json);
    }

    public function test_PUT_200()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/1', 'PUT', ['stock' => 9]);

        $this->assertResponseStatusCode(200);

        $body = $this->getResponse()->getContent();
        $this->assertJson($body);

        $json = Json::decode($body, true);
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('stock', $json);
        $this->assertEquals(9, $json['stock']);
    }

    public function test_DELETE_1_401()
    {
        //$this->addTokenHeaderLine();

        $this->dispatch('/api/products/1', 'DELETE');

        $this->assertResponseStatusCode(401);
    }

    public function test_DELETE_1_404()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/0', 'DELETE');

        $this->assertResponseStatusCode(404);
    }

    public function test_DELETE_1_200()
    {
        $this->addTokenHeaderLine();

        $this->dispatch('/api/products/2', 'DELETE');

        $this->assertResponseStatusCode(200);
    }
}

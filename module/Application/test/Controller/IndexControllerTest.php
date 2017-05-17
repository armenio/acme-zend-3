<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace ApplicationTest\Controller;

define('ROOT_PATH', dirname(dirname(dirname(dirname(__DIR__)))));

use Cake\Datasource\ConnectionManager;
use stdClass;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Json\Json;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        error_reporting(0);

        //cria a conexão
        if (!ConnectionManager::getConfig('default')) {
            ConnectionManager::setConfig('default', [
                'className' => 'Cake\Database\Connection',
                'driver' => 'Cake\Database\Driver\Mysql',
                'persistent' => false,
                'host' => 'localhost',
                'database' => 'agenda',
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

    public function createAuthMock()
    {
        $identity = new stdClass();
        $identity->id = 1;
        $identity->name = 'Rafael Armenio';
        $identity->identity = 'rafael.armenio@gmail.com';

        //Mock the plugin interface for checking authorization
        $authMock = $this->createMock(AuthenticationServiceInterface::class);
        // Some expectations of the authentication service.
        $authMock->expects($this->any())
            ->method('hasIdentity')
            ->willReturn(true);
        $authMock->expects($this->any())
            ->method('getIdentity')
            ->willReturn($identity);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService(AuthenticationService::class, $authMock);
        $serviceManager->setAllowOverride(false);
    }

    public function testClearData()
    {
        //limpa os dados do banco
        ConnectionManager::get('default')->query('TRUNCATE TABLE `contacts`');
        ConnectionManager::get('default')->query('TRUNCATE TABLE `groups`');
        ConnectionManager::get('default')->query('TRUNCATE TABLE `users`');

        $this->assertTrue(true);
    }

    public function testCadastro()
    {
        $this->dispatch('/cadastro', 'POST', [
            'name' => 'Rafael Armenio',
            'identity' => 'rafael.armenio@gmail.com',
            'credential_confirmation' => '123456',
            'credential' => '123456',
        ]);

        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
    }

    public function testLogin()
    {
        $this->dispatch('/login', 'POST', [
            'identity' => 'rafael.armenio@gmail.com',
            'credential' => '123456',
            'remember_me' => 0,
        ]);

        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
    }

    public function testIndex()
    {
        $this->createAuthMock();

        $this->dispatch('/');

        $this->assertResponseStatusCode(200);
        $this->assertQuery('#groups-list');
        $this->assertQuery('#contacts-list');
    }

    public function testGruposCadastro()
    {
        $this->createAuthMock();

        $this->dispatch('/grupos/cadastro', 'POST', [
            'name' => 'Grupo 1',
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('groups', $json);
        $this->assertCount(1, $json['groups']);
    }

    public function testGruposCadastro2()
    {
        $this->createAuthMock();

        $this->dispatch('/grupos/cadastro', 'POST', [
            'name' => 'Grupo 2',
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('groups', $json);
        $this->assertCount(2, $json['groups']);
    }

    public function testGruposCadastro3()
    {
        $this->createAuthMock();

        $this->dispatch('/grupos/cadastro', 'POST', [
            'name' => 'Grupo 3',
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('groups', $json);
        $this->assertCount(3, $json['groups']);
    }

    public function testGruposVisualizar()
    {
        $this->createAuthMock();

        $this->dispatch('/grupos/visualizar/1');

        $this->assertResponseStatusCode(200);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('data', $json);
    }

    public function testGruposVisualizar2()
    {
        $this->createAuthMock();

        $this->dispatch('/grupos/visualizar/99999');

        $this->assertResponseStatusCode(404);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'error');
        $this->assertArrayHasKey('data', $json);
    }

    public function testGruposRemover()
    {
        $this->createAuthMock();

        $this->dispatch('/grupos/remover/3');

        $this->assertResponseStatusCode(200);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('groups', $json);
        $this->assertCount(2, $json['groups']);
    }

    public function testContatosCadastro()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/cadastro', 'POST', [
            'name' => 'Contato 1',
            'phone' => '(99) 9999-99999',
            'email' => 'email@dominio.com',
            'group_id' => 1,
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(1, $json['contacts']);
    }

    public function testContatosCadastro2()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/cadastro', 'POST', [
            'name' => 'Contato 2',
            'phone' => '(99) 9999-99999',
            'email' => 'email@dominio.com',
            'group_id' => 2,
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(2, $json['contacts']);
    }

    public function testContatosCadastro3()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/cadastro', 'POST', [
            'name' => 'Contato 3',
            'phone' => '(99) 9999-99999',
            'email' => 'email@dominio.com',
            'group_id' => 1,
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(3, $json['contacts']);
    }

    public function testContatosCadastro4()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/cadastro', 'POST', [
            'name' => 'Contato 4',
            'phone' => '(99) 9999-99999',
            'email' => 'email@dominio.com',
            'group_id' => 1,
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(4, $json['contacts']);
    }

    public function testContatosCadastro5()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/cadastro', 'POST', [
            'name' => 'Contato 5',
            'phone' => '(99) 9999-99999',
            'email' => 'email@dominio.com',
            'group_id' => 1,
        ]);

        $this->assertResponseStatusCode(201);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(5, $json['contacts']);
    }

    public function testContatosVisualizar()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/visualizar/1');

        $this->assertResponseStatusCode(200);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('data', $json);
    }

    public function testContatosVisualizar2()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/visualizar/99999');

        $this->assertResponseStatusCode(404);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'error');
        $this->assertArrayHasKey('data', $json);
    }

    public function testContatosFiltrar()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/filtrar', 'GET', [
            'q' => 'Contato 1',
        ]);

        $this->assertResponseStatusCode(200);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(1, $json['contacts']);

    }

    public function testContatosRemover()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/remover/3');

        $this->assertResponseStatusCode(200);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(4, $json['contacts']);
    }

    public function testContatosRemoverSelecionados()
    {
        $this->createAuthMock();

        $this->dispatch('/contatos/remover-selecionados', 'GET', [
            'ids' => [4, 5],
        ]);

        $this->assertResponseStatusCode(200);
        $body = $this->getResponse()->getContent();
        $json = Json::decode($body, true);
        $this->assertJson($body);
        $this->assertArrayHasKey('result', $json);
        $this->assertEquals($json['result'], 'success');
        $this->assertArrayHasKey('contacts', $json);
        $this->assertCount(2, $json['contacts']);
    }
}

<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api\Controller;

use Application\Form\ContactsForm;
use Application\Form\GroupsForm;
use Armenio\Cake\ORM\TableRegistry;
use Exception;
use Firebase\JWT\JWT;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Renderer\RendererInterface;

/**
 * Class ApiRestfulController
 * @package Api\Controller
 */
class ApiRestfulController extends AbstractRestfulController
{
    /**
     * @var TableRegistry
     */
    protected $tableRegistry;

    /**
     * @var SessionContainer
     */
    protected $session;

    /**
     * @var AuthenticationService
     */
    public $authentication;

    /**
     * @var ContainerInterface
     */
    protected $formManager;

    /**
     * @var RendererInterface
     */
    protected $viewRenderer;

    /**
     * @var array
     */
    protected $requestParams = [];

    /**
     * ApiRestfulController constructor.
     * @param TableRegistry $tableRegistry
     * @param SessionContainer $session
     * @param AuthenticationServiceInterface $authentication
     * @param ContainerInterface $formManager
     * @param RendererInterface $viewRenderer
     */
    public function __construct(TableRegistry $tableRegistry, SessionContainer $session, AuthenticationServiceInterface $authentication, ContainerInterface $formManager, RendererInterface $viewRenderer)
    {
        $this->tableRegistry = $tableRegistry;
        $this->session = $session;
        $this->authentication = $authentication;
        $this->formManager = $formManager;
        $this->viewRenderer = $viewRenderer;
    }

    CONST JWT_KEY = '7b3221424e33c69649f53d0411bda7a4e300e5ee2a8821e05478b16ce872ed97bf88d76ef12d4fe9';

    /**
     * @param $sub // User id
     * @return string
     */
    protected function generateToken($sub)
    {
        $iat = time();

        $token = [
            'iat' => $iat,
            'sub' => $sub,
            'exp' => $iat + (60 * 60 * 24 * 365),
        ];

        $payload = JWT::encode($token, self::JWT_KEY);

        return $payload;
    }

    /**
     * @return bool|object
     */
    public function getToken()
    {
        //$header = $this->getRequest()->getServer('HTTP_AUTHORIZATION');

        $headers = $this->getRequest()->getHeaders();

        if (!$headers->has('Authorization')) {
            return false;
        }

        $header = $headers->get('Authorization')->getFieldValue();

        $jwt = str_ireplace('Bearer ', '', $header);

        try {
            $payload = JWT::decode($jwt, self::JWT_KEY, ['HS256']);
        } catch (Exception $e) {
            return false;
        }

        return $payload;
    }
}
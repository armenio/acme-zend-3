<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application\Controller;

use Application\Form\ContactsForm;
use Application\Form\GroupsForm;
use Armenio\Cake\ORM\TableRegistry;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Renderer\RendererInterface;

/**
 * Class ApplicationActionController
 * @package Application\Controller
 */
class ApplicationActionController extends AbstractActionController
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
     * ApplicationActionController constructor.
     * @param TableRegistry $tableRegistry
     * @param SessionContainer $session
     * @param AuthenticationService $authentication
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

    /**
     * @return void
     */
    protected function init()
    {
        $this->requestParams = [
            'files' => $this->params()->fromFiles(),
            'post' => $this->params()->fromPost(),
            'query' => $this->params()->fromQuery(),
            'route' => $this->params()->fromRoute(),
            'server' => $this->getRequest()->getServer(),
        ];
    }

    /**
     * @return mixed
     */
    public function formContacts()
    {
        $valueOptions = $this->tableRegistry->get('Groups')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'conditions' => [
                'user_id' => $this->identity()->id,
            ],
            'order' => [
                'name' => 'asc',
            ],
        ])->toArray();

        $form = $this->formManager->get(ContactsForm::class);

        $groupId = $form->get('group_id');

        $options = $groupId->getOptions();
        $options['value_options'] = [
                '' => 'Todos os contatos'
            ] + $valueOptions;

        $groupId->setOptions($options);

        return $form;
    }

    /**
     * @return mixed
     */
    public function formGroups()
    {
        $form = $this->formManager->get(GroupsForm::class);

        return $form;
    }
}
<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application\Controller;

use Application\Form\GroupsForm;
use Application\Form\LoginForm;
use Application\Form\UsersForm;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends ApplicationActionController
{
    /**
     * Action principal do sistema que resolve a dashboard de gerenciamento de contatos e grupos
     * @return array|\Zend\Http\Response
     */
    public function indexAction()
    {
        if (!$this->identity()) {
            return $this->redirect()->toUrl($this->getRequest()->getBasePath() . '/login?destino=' . urlencode('/'));
        }

        $this->layout()->headTitle = 'Meus contatos';

        return [
            'requestParams' => $this->requestParams,
            'formContacts' => $this->formContacts(),
            'formGroups' => $this->formGroups(),
            'contacts' => $this->tableRegistry->get('Contacts')->getUserContacts($this->identity()->id),
            'groups' => $this->tableRegistry->get('Groups')->getUserGroups($this->identity()->id),
        ];
    }

    /**
     * Facilitador de logout de usuários
     */
    private function logout()
    {
        if ($this->identity()) {
            $this->authentication->getStorage()->forgetMe();
            $this->authentication->clearIdentity();
        }
    }

    /**
     * Action de login do sistema
     * @return array|\Zend\Http\Response
     */
    public function loginAction()
    {
        $this->init();

        $this->logout();

        $this->layout()->headTitle = 'Identificação';

        if (isset($this->requestParams['query']['logout'])) {
            $this->flashMessenger()->addMessage([
                'form' => 'login',
                'message' => 'Logout efetuado com sucesso.',
                'type' => 'success',
                'icon' => 'check',
            ]);

            return $this->redirect()->toUrl($this->getRequest()->getBasePath() . '/login');
        }

        $form = $this->formManager->get(LoginForm::class);

        if ($this->getRequest()->isPost()) {
            $data = $this->requestParams['post'];

            $form->setData($data);

            if (!$form->isValid()) {
                $this->flashMessenger()->addMessage([
                    'form' => 'login',
                    'message' => 'Não foi possível validar os dados.',
                    'type' => 'danger',
                    'icon' => 'ban',
                ]);
            } else {
                $data = $form->getData();

                if ($data['remember_me']) {
                    $this->authentication->getStorage()->rememberMe(30 * 24 * 60 * 60);
                }

                $adapter = $this->authentication->getAdapter();
                $adapter->setIdentity($data['identity']);
                $adapter->setCredential($data['credential']);
                $authenticationResult = $this->authentication->authenticate();

                if (!$authenticationResult->isValid()) {
                    $messages = $authenticationResult->getMessages();

                    $this->flashMessenger()->addMessage([
                        'form' => 'login',
                        'message' => $messages[0],
                        'type' => 'danger',
                        'icon' => 'ban',
                    ]);
                } else {
                    $this->authentication->getStorage()->write($this->authentication->getAdapter()->getResultRowObject(null, ['created_at', 'updated_at', 'deleted_at', 'active', 'credential']));

                    if (isset($this->requestParams['query']['destino'])) {
                        return $this->redirect()->toUrl($this->getRequest()->getBasePath() . $this->requestParams['query']['destino']);
                    } else {
                        return $this->redirect()->toUrl($this->getRequest()->getBasePath() . '/');
                    }
                }
            }
        }

        return [
            'form' => $form,
            'requestParams' => $this->requestParams,
        ];
    }

    /**
     * Action de cadastro de usuários
     * @return array|\Zend\Http\Response
     */
    public function cadastroAction()
    {
        $this->init();

        $this->layout()->headTitle = 'Cadastro';

        $form = $this->formManager->get(UsersForm::class);

        if ($this->identity()) {
            $form->get('identity')->setAttribute('readonly', true);
        }

        $form->get('submit')->setAttribute('class', 'btn btn-primary btn-padding btn-xs-block text-uppercase animated');
        $form->get('submit')->setLabel('Cadastre-se');

        $tableUsers = $this->tableRegistry->get('Users');

        if ($this->getRequest()->isPost()) {
            $data = $this->requestParams['post'];

            if ($this->identity()) {
                $data['id'] = $this->identity()->id;
                $data['identity'] = $this->identity()->identity;

                if (empty($data['credential']) && empty($data['credential_confirmation'])) {
                    unset($data['credential']);
                    unset($data['credential_confirmation']);
                }
            } else {
                $data['id'] = null;
            }

            $form->setData($data);

            if (!$form->isValid()) {
                $this->flashMessenger()->addMessage([
                    'form' => 'register',
                    'message' => 'Não foi possível validar os dados.',
                    'type' => 'danger',
                    'icon' => 'ban',
                ]);
            } else {
                $data = $form->getData();

                $credential = $data['credential'];

                if (empty($data['credential'])) {
                    unset($data['credential']);
                } else {
                    $bcrypt = new Bcrypt();
                    $bcrypt->setCost(10);

                    $data['credential'] = $bcrypt->create($credential);
                }

                if (!empty($data['id'])) {
                    $entity = $tableUsers->get($data['id']);
                } else {
                    $entity = $tableUsers->newEntity();
                }

                $tableUsers->patchEntity($entity, $data);

                if ($data = $tableUsers->save($entity)) {

                    if ($this->identity()) {
                        $this->identity()->name = $data['name'];
                        $this->identity()->identity = $data['identity'];
                    } else {
                        $this->authentication->getStorage()->rememberMe(30 * 24 * 60 * 60);

                        $adapter = $this->authentication->getAdapter();
                        $adapter->setIdentity($data['identity']);
                        $adapter->setCredential($credential);
                        $authenticationResult = $this->authentication->authenticate();

                        if ($authenticationResult->isValid()) {
                            $this->authentication->getStorage()->write($this->authentication->getAdapter()->getResultRowObject(null, ['created_at', 'updated_at', 'deleted_at', 'active', 'credential']));
                        }
                    }

                    if (isset($this->requestParams['query']['destino'])) {
                        return $this->redirect()->toUrl($this->getRequest()->getBasePath() . $this->requestParams['query']['destino']);
                    } else {
                        $this->flashMessenger()->addMessage([
                            'form' => 'register',
                            'message' => 'Os dados foram salvos com sucesso.',
                            'type' => 'success',
                            'icon' => 'check',
                        ]);

                        return $this->redirect()->toUrl($this->getRequest()->getBasePath() . '/');
                    }
                }
            }
        } else if ($this->identity()) {
            $user = $tableUsers->get($this->identity()->id);

            $form->setData($user->toArray());

            $form->get('submit')->setLabel('Salvar as informações');
        }

        return [
            'form' => $form,
            'requestParams' => $this->requestParams,
        ];
    }
}

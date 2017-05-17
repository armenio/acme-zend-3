<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api\Controller;

use Api\Form\LoginForm;
use Api\Form\UsersForm;
use Zend\Crypt\Password\Bcrypt;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

/**
 * Class UsersController
 * @package Application\Controller
 */
class UsersController extends ApiRestfulController
{
    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data) //POST /
    {
        $jsonModel = new JsonModel();

        $form = $this->formManager->get(UsersForm::class);

        $form->setData($data);

        if (!$form->isValid()) {
            $jsonModel->setVariable('errors', $form->getMessages());

            $statusCode = '400';
        } else {
            $data = $form->getData();

            $bcrypt = new Bcrypt();
            $bcrypt->setCost(10);

            $data['password'] = $bcrypt->create($data['password']);

            $table = $this->tableRegistry->get('Users');
            $entity = $table->newEntity();
            $table->patchEntity($entity, $data);

            $data = $table->save($entity);

            $jsonModel->setVariables([
                'token' => $this->generateToken($data->id),
                'user' => $data->toArray(),
            ]);

            $statusCode = '201';
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id) //DELETE /1
    {
        $jsonModel = new JsonModel();

        $token = $this->getToken();

        if (!$token || $token->sub != $id) {
            $statusCode = '401';
        } else {
            $table = $this->tableRegistry->get('Users');

            if (!$table->exists(['id' => $id])) {
                $statusCode = '404';
            } else {
                $entity = $table->get($id);

                $table->delete($entity);

                $statusCode = '200';
            }
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }

    /**
     * Return single resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function get($id) //GET /1
    {
        $jsonModel = new JsonModel();

        $token = $this->getToken();

        if (!$token || $token->sub != $id) {
            $statusCode = '401';
        } else {
            $table = $this->tableRegistry->get('Users');

            if (!$table->exists(['id' => $id])) {
                $statusCode = '404';
            } else {
                $data = $table->get($id)->toArray();

                $jsonModel->setVariables($data);
                $statusCode = '200';
            }
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data) //PUT /1
    {
        $jsonModel = new JsonModel();

        $token = $this->getToken();

        if (!$token || $token->sub != $id) {
            $statusCode = '401';
        } else {
            $table = $this->tableRegistry->get('Users');

            if (!$table->exists(['id' => $id])) {
                $statusCode = '404';
            } else {
                $data['id'] = $id;

                $form = $this->formManager->get(UsersForm::class);

                $form->setData($data);

                if (!$form->isValid()) {
                    $jsonModel->setVariable('errors', $form->getMessages());

                    $statusCode = '400';
                } else {
                    $data = array_intersect_key($form->getData(), $data);

                    if (isset($data['password']) && trim($data['password']) === '' && isset($data['passwordConfirmation']) && trim($data['passwordConfirmation']) === '') {
                        unset($data['password']);
                        unset($data['passwordConfirmation']);
                    }

                    if (isset($data['password'])) {
                        $bcrypt = new Bcrypt();
                        $bcrypt->setCost(10);

                        $data['password'] = $bcrypt->create($data['password']);
                    }

                    $entity = $table->get($id);
                    $table->patchEntity($entity, $data);

                    $data = $table->save($entity);

                    unset($data['password']);
                    unset($data['passwordConfirmation']);

                    $jsonModel->setVariables($data->toArray());
                    $statusCode = '200';
                }
            }
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }

    public function loginCheckAction()
    {
        $jsonModel = new JsonModel();

        if (!$this->getRequest()->isPost()) {
            $statusCode = '405';
        } else {
            $data = $this->params()->fromPost();

            $form = $this->formManager->get(LoginForm::class);

            $form->setData($data);

            if (!$form->isValid()) {
                $jsonModel->setVariable('errors', $form->getMessages());

                $statusCode = '400';
            } else {
                $data = $form->getData();

                $adapter = $this->authentication->getAdapter();
                $adapter->setIdentity($data['username']);
                $adapter->setCredential($data['password']);
                $authenticationResult = $this->authentication->authenticate();

                if (!$authenticationResult->isValid()) {
                    $messages = $authenticationResult->getMessages();

                    $this->flashMessenger()->addMessage([
                        'form' => 'login',
                        'message' => $messages[0],
                        'type' => 'danger',
                        'icon' => 'ban',
                    ]);

                    $jsonModel->setVariables([
                        'message' => $this->viewRenderer->translate($messages[0]),
                    ]);

                    $statusCode = '401';
                } else {
                    $data = $this->authentication->getAdapter()->getResultRowObject(null, ['password']);

                    $jsonModel->setVariables([
                        'token' => $this->generateToken($data->id),
                        'user' => Json::decode(Json::encode($data), true),
                    ]);

                    $statusCode = '200';
                }
            }
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }
}

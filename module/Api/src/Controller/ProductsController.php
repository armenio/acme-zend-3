<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api\Controller;

use Api\Form\ProductsForm;
use Cake\Utility\Inflector;
use PDOException;
use Zend\View\Model\JsonModel;

/**
 * Class ProductsController
 * @package Application\Controller
 */
class ProductsController extends ApiRestfulController
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

        $token = $this->getToken();

        if (!$token) {
            $statusCode = '401';
        } else {
            $form = $this->formManager->get(ProductsForm::class);

            $form->setData($data);

            if (!$form->isValid()) {
                $jsonModel->setVariable('errors', $form->getMessages());

                $statusCode = '400';
            } else {
                $data = $form->getData();

                $table = $this->tableRegistry->get('Products');
                $entity = $table->newEntity();
                $table->patchEntity($entity, $data);

                $data = $table->save($entity);

                $jsonModel->setVariables($data->toArray());
                $statusCode = '201';
            }
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

        if (!$token) {
            $statusCode = '401';
        } else {
            $table = $this->tableRegistry->get('Products');

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

        if (!$token) {
            $statusCode = '401';
        } else {
            $table = $this->tableRegistry->get('Products');

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
     * Return list of resources
     *
     * @return mixed
     */
    public function getList() //GET /
    {
        $jsonModel = new JsonModel();

        $token = $this->getToken();

        if (!$token) {
            $statusCode = '401';
        } else {
            try {
                $table = $this->tableRegistry->get('Products');

                $options = [];

                $q = trim($this->params()->fromQuery('q', ''));

                if ($q) {
                    $options['conditions'] = [
                        'name LIKE' => "%{$q}%",
                    ];
                }

                $options['order'] = [
                    Inflector::underscore($this->params()->fromQuery('order', 'stock')) => $this->params()->fromQuery('by', 'asc'),
                ];

                $data = $table->find('all', $options)->all()->toArray();

                $jsonModel->setVariables($data);

                $statusCode = '200';
            } catch (PDOException $e) {
                $statusCode = '400';
            }
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }

    /**
     * Respond to the OPTIONS method
     *
     * Typically, set the Allow header with allowed HTTP methods, and
     * return the response.
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @return mixed
     */
    public function options()
    {
        return $this->getList();
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

        if (!$token) {
            $statusCode = '401';
        } else {
            $table = $this->tableRegistry->get('Products');

            if (!$table->exists(['id' => $id])) {
                $statusCode = '404';
            } else {
                $data['id'] = $id;

                $form = $this->formManager->get(ProductsForm::class);

                $form->setData($data);

                if (!$form->isValid()) {
                    $jsonModel->setVariable('errors', $form->getMessages());

                    $statusCode = '400';
                } else {
                    $data = array_intersect_key($form->getData(), $data);

                    $entity = $table->get($id);
                    $table->patchEntity($entity, $data);

                    $data = $table->save($entity);

                    $jsonModel->setVariables($data->toArray());
                    $statusCode = '200';
                }
            }
        }

        $this->getResponse()->setStatusCode($statusCode);

        return $jsonModel;
    }
}

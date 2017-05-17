<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application\Form;

use Armenio\Cake\ORM\TableRegistry;
use Zend\Db\Adapter\AdapterInterface as DbAdapterInterface;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Class LoginForm
 * @package Application\Form
 */
class LoginForm extends Form implements InputFilterProviderInterface
{
    /**
     * @var TableRegistry
     */
    protected $tableRegistry;

    /**
     * @var DbAdapterInterface
     */
    protected $db;

    /**
     * @var array
     */
    public $inputFilterSpecification = [];

    /**
     * LoginForm constructor.
     * @param TableRegistry $tableRegistry
     * @param DbAdapterInterface $db
     */
    public function __construct(TableRegistry $tableRegistry, DbAdapterInterface $db)
    {
        $this->tableRegistry = $tableRegistry;
        $this->db = $db;

        parent::__construct();

        $this->add([
            'name' => 'identity',
            'attributes' => [
                'id' => 'element_identity',
                'class' => 'form-control',
                'placeholder' => 'Seu e-mail',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'E-mail',
                'value_options' => array(),
            ],
            'type' => 'email',
        ]);

        $this->add([
            'name' => 'credential',
            'attributes' => [
                'id' => 'element_credential',
                'class' => 'form-control',
                'placeholder' => 'Sua senha',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Senha',
                'value_options' => array(),
            ],
            'type' => 'password',
        ]);

        $this->add([
            'name' => 'remember_me',
            'attributes' => [
                'id' => 'element_remember_me',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Permanecer logado',
            ],
            'type' => 'checkbox',
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-primary btn-block text-uppercase animated',
                'type' => 'submit',
            ],
            'options' => [
                'label' => 'Acessar',
            ],
            'type' => 'button',
        ]);
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->getFieldsets() as $fieldset) {
            if (isset($this->data[$fieldset->getName()])) {
                $fieldset->data = $this->data[$fieldset->getName()];
            }
        }

        if (parent::isValid()) {
            $this->filter = null;
            $this->hasAddedInputFilterDefaults = false;
            $this->hasValidated = false;
            $this->messages = [];

            $this->setInputFilterSpecification();

            $this->setData($this->data);

            foreach ($this->getFieldsets() as $fieldset) {
                $fieldset->isValid = true;
                $fieldset->setInputFilterSpecification();
            }

            parent::isValid();
        }

        return $this->isValid;
    }

    /**
     * @return $this
     */
    public function setInputFilterSpecification()
    {

        $this->inputFilterSpecification['identity'] = [
            'required' => true,
            'filters' => [
                'stringTrim' => [
                    'name' => 'stringTrim',
                ],
            ],
            'validators' => [

                'emailAddress' => [
                    'name' => 'emailAddress',
                ],

                /*'dbNoRecordExists' => [
                    'name' => 'dbNoRecordExists',
                    'options' => [
                        'table' => 'user',
                        'field' => 'identity',
                        'adapter' => $this->db,
                        'exclude' => sprintf('%s =1', $this->db->platform->quoteIdentifier('active')) . (!empty($this->data['id']) ? sprintf(' AND %s !=%s', $this->db->platform->quoteIdentifier('id'), $this->data['id']) : ''),
                    ],
                ],*/

            ],
        ];

        $this->inputFilterSpecification['credential'] = [
            'required' => true,
            'filters' => [

                'stringTrim' => [
                    'name' => 'stringTrim',
                ],

            ],
            'validators' => [

                'stringLength' => [
                    'name' => 'stringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 20,
                    ],
                ],

            ],
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        if (!$this->inputFilterSpecification) {
            $this->setInputFilterSpecification();
        }
        return $this->inputFilterSpecification;
    }
}
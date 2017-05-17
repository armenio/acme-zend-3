<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api\Form;

use Armenio\Cake\ORM\TableRegistry;
use Zend\Db\Adapter\AdapterInterface as DbAdapterInterface;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Class UsersForm
 * @package Api\Form
 */
class UsersForm extends Form implements InputFilterProviderInterface
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
     * UsersForm constructor.
     * @param TableRegistry $tableRegistry
     * @param DbAdapterInterface $db
     */
    public function __construct(TableRegistry $tableRegistry, DbAdapterInterface $db)
    {
        $this->tableRegistry = $tableRegistry;
        $this->db = $db;

        parent::__construct();

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'name',
            'attributes' => [
                'id' => 'element_name',
                'class' => 'form-control',
                'placeholder' => 'Seu nome',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Nome',
                'value_options' => array(),
            ],
            'type' => 'text',
        ]);

        $this->add([
            'name' => 'username',
            'attributes' => [
                'id' => 'element_username',
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
            'name' => 'password',
            'attributes' => [
                'id' => 'element_password',
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
            'name' => 'passwordConfirmation',
            'attributes' => [
                'id' => 'element_passwordConfirmation',
                'class' => 'form-control',
                'placeholder' => 'Sua senha',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Confirmar Senha',
                'value_options' => array(),
            ],
            'type' => 'password',
        ]);

        /*$this->add([
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-success',
                'type' => 'submit',
            ],
            'options' => [
                //'label' => '<i class="fa fa-floppy-o"></i> Enviar',
                'label' => 'Enviar',
                'label_options' => [
                    //'disable_html_escape' => true,
                ],
            ],
            'type' => 'button',
        ]);*/
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

        $this->inputFilterSpecification['name'] = [
            'required' => true,
            'filters' => [

                    'stringTrim' => [
                        'name' => 'stringTrim',
                    ],

                ] + ($this->isValid ? [

                ] : []),
            'validators' => [

            ],
        ];

        $this->inputFilterSpecification['username'] = [
            'required' => true,
            'filters' => [

                    'stringTrim' => [
                        'name' => 'stringTrim',
                    ],

                ] + ($this->isValid ? [

                ] : []),
            'validators' => [

                'emailAddress' => [
                    'name' => 'emailAddress',
                ],

                'dbNoRecordExists' => [
                    'name' => 'dbNoRecordExists',
                    'options' => [
                        'table' => 'users',
                        'field' => 'username',
                        'adapter' => $this->db,
                        'exclude' => sprintf('%s =1', 1/*$this->db->platform->quoteIdentifier('active')*/) . (!empty($this->data['id']) ? sprintf(' AND %s !=%s', $this->db->platform->quoteIdentifier('id'), $this->data['id']) : ''),
                    ],
                ],

            ],
        ];

        if (empty($this->data['id']) || isset($this->data['password'])) {
            $this->inputFilterSpecification['password'] = [
                'required' => true,
                'filters' => [

                        'stringTrim' => [
                            'name' => 'stringTrim',
                        ],

                    ] + ($this->isValid ? [

                    ] : []),
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
        }

        if (empty($this->data['id']) || isset($this->data['password'])) {
            $this->inputFilterSpecification['passwordConfirmation'] = [
                'required' => true,
                'filters' => [

                    'stringTrim' => [
                        'name' => 'stringTrim',
                    ],

                ],
                'validators' => [

                    'identical' => [
                        'name' => 'identical',
                        'options' => [
                            'token' => 'password',
                        ],
                    ],

                ],

            ];
        }

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
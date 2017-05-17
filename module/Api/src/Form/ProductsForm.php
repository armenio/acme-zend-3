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
 * Class ProductsForm
 * @package Api\Form
 */
class ProductsForm extends Form implements InputFilterProviderInterface
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
     * ProductsForm constructor.
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
                'placeholder' => '',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Nome do produto',
                'value_options' => array(),
            ],
            'type' => 'text',
        ]);

        $this->add([
            'name' => 'description',
            'attributes' => [
                'id' => 'element_description',
                'class' => 'form-control',
                'placeholder' => '',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Descrição do produto',
                'value_options' => array(),
            ],
            'type' => 'textarea',
        ]);

        $this->add([
            'name' => 'price',
            'attributes' => [
                'id' => 'element_price',
                'class' => 'form-control',
                'placeholder' => '',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Preço do produto',
                'value_options' => array(),
            ],
            'type' => 'text',
        ]);

        $this->add([
            'name' => 'stock',
            'attributes' => [
                'id' => 'element_stock',
                'class' => 'form-control',
                'placeholder' => '',
                'readonly' => false,
                'disabled' => false,
                'value' => '',
            ],
            'options' => [
                'label' => 'Quantidade em estoque',
                'value_options' => array(),
            ],
            'type' => 'number',
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
            'required' => empty($this->data['id']),
            'filters' => [

                    'stringTrim' => [
                        'name' => 'stringTrim',
                    ],

                ] + ($this->isValid ? [

                ] : []),
            'validators' => [

            ],
        ];

        $this->inputFilterSpecification['description'] = [
            'required' => false,
            'filters' => [

                    'stringTrim' => [
                        'name' => 'stringTrim',
                    ],

                ] + ($this->isValid ? [

                ] : []),
            'validators' => [

            ],
        ];

        $this->inputFilterSpecification['price'] = [
            'required' => empty($this->data['id']),
            'filters' => [

                    'stringTrim' => [
                        'name' => 'stringTrim',
                    ],

                ] + ($this->isValid ? [

                    'numberParse' => [
                        'name' => 'numberParse',
                    ],

                ] : []),
            'validators' => [

            ],
        ];

        $this->inputFilterSpecification['stock'] = [
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
<?php

declare(strict_types=1);

namespace Person\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

class PersonForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('person');

        $this->add([
            'type' => Element\Text::class,
            'name' => 'firstname',
            'options' => [
                'label' => 'FirstName',
            ],
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'lastname',
            'options' => [
                'label' => 'LastName',
            ],
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Submit',
            ],
        ]);

    }

    public function getInputFilterSpecification()
    {
        return [
            'firstname' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            'lastname' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
        ];
    }
}
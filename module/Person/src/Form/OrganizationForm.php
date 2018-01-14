<?php
declare(strict_types=1);

namespace Person\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;


class OrganizationForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('organization');

        $this->add([
            'type' => Element\Text::class,
            'name' => 'name',
            'options' => [
                'label' => 'Name',
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
            'name' => [
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
<?php

declare(strict_types=1);

namespace Rally\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

class MeetupForm extends Form implements InputFilterProviderInterface
{

    public function __construct()
    {
        parent::__construct('meetup');

        $this->add([
            'type' => Element\Text::class,
            'name' => 'title',
            'options' => [
                'label' => 'Title',
            ],
        ]);

        $this->add([
            'type' => Element\Textarea::class,
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'dateBegin',
            'options' => [
                'label' => 'Date de début',
                'format' => 'Y-m-d',
            ],
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'dateEnd',
            'options' => [
                'label' => 'Date de fin',
                'format' => 'Y-m-d',
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
            'title' => [
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
            'description' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 200,
                        ],
                    ],
                ],
            ],
        ];
    }
}

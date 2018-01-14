<?php

declare(strict_types=1);

namespace Person\Controller;

use Person\Entity\Person;
use Person\Form\PersonForm;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;


final class PersonControllerFactory
{
    public function __invoke(ContainerInterface $container) : PersonController
    {
        $personRepository = $container->get(EntityManager::class)->getRepository(Person::class);
        $personForm = $container->get(PersonForm::class);

        return new PersonController($personRepository, $personForm);
    }
}
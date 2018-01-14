<?php

declare(strict_types=1);

namespace Person\Controller;

use Person\Entity\Organization;
use Person\Form\OrganizationForm;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;


final class OrganizationControllerFactory
{
    public function __invoke(ContainerInterface $container) : OrganizationController
    {
        $organizationRepository = $container->get(EntityManager::class)->getRepository(Organization::class);
        $organizationForm = $container->get(OrganizationForm::class);

        return new OrganizationController($organizationRepository, $organizationForm);
    }
}
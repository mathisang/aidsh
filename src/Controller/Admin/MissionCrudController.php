<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class MissionCrudController extends AbstractCrudController
{
    public function __construct(AdminUrlGenerator $adminUrlGenerator, MissionRepository $missionRepository, EntityManagerInterface $objectManager, UserRepository $userRepository)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->missionRepository = $missionRepository;
        $this->objectManager = $objectManager;
        $this->userRepository = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // SHOW
            IdField::new('id')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('name')
                ->setFormTypeOption('disabled', 'disabled'),
            TextareaField::new('description')
                ->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('date_end')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('priority')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('client')
                ->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('date_realisation'),
            TextField::new('status')
                ->setFormTypeOption('disabled', 'disabled'),
            AssociationField::new('vilain')
                ->setFormTypeOption('disabled', 'disabled')
                ->hideOnDetail(),
            AssociationField::new('superhero')
                ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                    return $queryBuilder->where("entity.roles LIKE '%ROLE_SUPER_HERO%'");
                })
                ->setFormTypeOption('disabled', 'disabled')
                ->hideOnDetail(),
            ArrayField::new('vilain')->onlyOnDetail(),
            ArrayField::new('superhero')->onlyOnDetail(),

            // EDIT PERMISSIONS CLIENT
            TextField::new('name')->onlyOnForms()->setPermission('ROLE_CLIENT'),
            TextareaField::new('description')->onlyOnForms()->setPermission('ROLE_CLIENT'),
            DateTimeField::new('date_end')->onlyOnForms()->setPermission('ROLE_CLIENT'),
            ChoiceField::new('priority')->setChoices([
                'Low' => 'Low',
                'Medium' => 'Medium',
                'High' => 'High'
            ])->setPermission('ROLE_CLIENT'),

            // EDIT PERMISSIONS SUPER HERO
            ChoiceField::new('status')->onlyOnForms()->setPermission('ROLE_SUPER_HERO')->setChoices([
                'To validate' => 'To validate',
                'To do' => 'To do',
                'In progress' => 'In progress',
                'Done' => 'Done'
            ]),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $clientId = $this->getUser();
        $client = $this->userRepository->find($clientId);

        $entity = new Mission();
        $entity->setStatus("To validate");
        $entity->setClient($client);

        return $entity;
    }

    public function configureActions(Actions $actions): Actions
    {
        $user = $this->getUser();

        $validMission = Action::new('validMission', 'Validate', 'fa fa-check')
            ->displayIf(static function ($entity) {
                return $entity->getStatus() == "To validate";
            })
            ->linkToCrudAction('validMission');

        $declineMission = Action::new('declineMission', 'Decline', 'fa fa-times')
            ->displayIf(static function ($entity) {
                return $entity->getStatus() == "To validate";
            })
            ->linkToCrudAction('declineMission');

        $actions
            ->setPermission(Action::NEW, 'ROLE_CLIENT')
            ->setPermission(Action::EDIT, 'ROLE_CLIENT')
            ->setPermission('validMission', 'ROLE_ADMIN')
            ->setPermission('declineMission', 'ROLE_ADMIN')
            ->remove(Action::INDEX, Action::BATCH_DELETE)
            ->remove(Action::INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Crud::PAGE_DETAIL)
            ->add(Crud::PAGE_INDEX, $validMission)
            ->add(Crud::PAGE_INDEX, $declineMission)
            ->remove(Action::DETAIL, Action::DELETE);

        if (in_array('ROLE_SUPER_HERO', $user->getRoles())) {
            $actions
                ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) use ($user) {
                    return $action->displayIf(function (Mission $mission) use ($user) {
                        return $mission->getSuperhero()->contains($user);
                    });
                })
                ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) use ($user) {
                    return $action->displayIf(function (Mission $mission) use ($user) {
                        return $mission->getSuperhero()->contains($user);
                    });
                })
                ->setPermission(Action::EDIT, 'ROLE_SUPER_HERO');
        }

        if (in_array('ROLE_CLIENT', $user->getRoles())) {
            $actions
                ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                    return $action->displayIf(function (Mission $mission) {
                        return $mission->getStatus() == "To validate";
                    });
                })
                ->add(Crud::PAGE_INDEX, Action::DELETE)
                ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                    return $action->displayIf(function (Mission $mission) {
                        return $mission->getStatus() == "To validate" || $mission->getStatus() == "To do";
                    });
                })
                ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                    return $action->displayIf(function (Mission $mission) {
                        return $mission->getStatus() == "To validate";
                    });
                })
                ->add(Crud::PAGE_DETAIL, Action::DELETE)
                ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                    return $action->displayIf(function (Mission $mission) {
                        return $mission->getStatus() == "To validate" || $mission->getStatus() == "To do";
                    });
                });
        }

        return $actions;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $roles = $this->getUser()->getRoles();
        $client = $this->getUser();

        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (in_array('ROLE_CLIENT', $roles)) {
            $response->where('entity.client = :client')->setParameter("client", $client);
        } elseif (in_array('ROLE_SUPER_HERO', $roles)) {
            $response->where('entity.status != :status')->setParameter("status", "To validate");
        }
        return $response;
    }

    public function validMission(AdminContext $context)
    {
        $id = $context->getRequest()->query->get('entityId');

        $mission = $this->missionRepository->find($id);
        $mission->setStatus("To do");

        $this->objectManager->persist($mission);
        $this->objectManager->flush();

        $this->addFlash('success', 'Mission updated !');

        $url = $this->get(AdminUrlGenerator::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function declineMission(AdminContext $context)
    {
        $id = $context->getRequest()->query->get('entityId');

        $mission = $this->missionRepository->find($id);
        $this->objectManager->remove($mission);
        $this->objectManager->flush();

        $this->addFlash('warning', 'Mission declined !');

        return $this->redirect('http://127.0.0.1:8000/admin?crudAction=index&crudControllerFqcn=App%5CController%5CAdmin%5CMissionCrudController&menuIndex=1&signature=igM4o8NjLQArnsAYKMMVlvtBOf1KRPzT0lSASEeqYEI&submenuIndex=-1');
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

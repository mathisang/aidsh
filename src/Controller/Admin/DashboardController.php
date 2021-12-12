<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Entity\User;
use App\Entity\Vilain;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Aidsh');
    }

    public function configureMenuItems(): iterable
    {
        $roles = $this->getUser()->getRoles();

        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Missions', 'fas fa-file-alt', Mission::class);
        if (in_array('ROLE_ADMIN' , $roles)) {
            yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
            yield MenuItem::linkToCrud('Villains', 'fas fa-user-ninja', Vilain::class);
        }
    }
}

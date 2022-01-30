<?php

namespace App\Controller\Admin;

use App\Entity\Styles;
use App\Entity\User;
use App\Entity\Vinyle;
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
            ->setTitle('Casemate');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Clients', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Styles', 'fa fa-tag', Styles::class);
        yield MenuItem::linkToCrud('Vinyles', 'fa fa-certificate', Vinyle::class);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Formula;
use App\Entity\Menu;
use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();
//        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
//        // ...set chart data and options somehow
//
//        return $this->render('admin/my-dashboard.html.twig', [
//            'chart' => $chart,
//        ]);
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(FormulaCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),

            MenuItem::section('La Carte'),
            MenuItem::linkToCrud('Menus', 'fa-solid fa-clipboard-list', Menu::class),
            MenuItem::linkToCrud('Formules', 'fa-solid fa-bars', Formula::class),

            MenuItem::section('Cuisine'),
            MenuItem::linkToCrud('Plats', 'fa-solid fa-fish', Dish::class),
            MenuItem::linkToCrud('Catégories', '', Category::class),

            MenuItem::section(('Horaires')),
            MenuItem::linkToCrud('Panneau horaires', '',Schedule::class)
        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

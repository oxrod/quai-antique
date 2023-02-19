<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCutleryNumber($form->get('cutleryNumber')->getData());
            $user->setEmail($form->get('email')->getData());
            $formAllergies = $form->get('allergies')->getData();
            foreach($formAllergies as $allergy) {
                $user->AddAllergy($allergy);
            }
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // Login the user after successfully created an account
            $security->login($user);

            return $this->redirectToRoute('app_home');
        }

        $days = $entityManager->getRepository(Schedule::class)->findAll();

        return $this->render('registration/register.html.twig', [
            'days' => $days,
            'registrationForm' => $form->createView(),
        ]);
    }
}

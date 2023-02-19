<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

namespace App\Controller;

use App\Entity\Allergy;
use App\Entity\Schedule;
use App\Entity\User;
use App\Form\UserAllergiesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED");

        $em = $managerRegistry->getManager();
        $loggedInUser = $this->getUser();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $loggedInUser->getUserIdentifier()]);

        $allergies = $user->getAllergies();
        $allergies_form = $this->createForm(UserAllergiesType::class);

        $allergies_form->handleRequest($request);
        if ($allergies_form->isSubmitted() && $allergies_form->isValid()) {
            $newAllergy = $allergies_form->get('allergies')->getData();
            $user->addAllergy($newAllergy);
            $em->persist($user);
            $em->persist($newAllergy);
            $em->flush();

            return $this->redirect('/profile');
        }

        // Allergy removal logic
        $remove_allergies_form = $this->createFormBuilder()
            ->add('allergyToRemove', ChoiceType::class, [
                'choices' => $allergies,
                'choice_label' => function (?Allergy $allergy) {
                    return $allergy ? $allergy->getName() : "";
                },
                'label' => 'Sélectionnez l\'allergie à retirer',
                'multiple' => false,
            ])
            ->getForm();
        $remove_allergies_form->handleRequest($request);
        if ($remove_allergies_form->isSubmitted() && $remove_allergies_form->isValid()) {
            $allergyToRemove = $remove_allergies_form->get('allergyToRemove')->getData();
            $loggedInUser->removeAllergy($allergyToRemove);
            $em->persist($loggedInUser);
            $em->persist($allergyToRemove);
            $em->flush();

            return $this->redirect('/profile');
        }

        $days = $em->getRepository(Schedule::class)->findAll();
        return $this->render('profile/index.html.twig', [
            'days' => $days,
            'allergies' => $allergies,
            'allergies_form' => $allergies_form->createView(),
            'remove_allergies_form' => $remove_allergies_form->createView(),
        ]);
    }
}

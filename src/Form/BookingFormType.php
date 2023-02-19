<?php

namespace App\Form;

use App\Entity\Allergy;
use App\Entity\User;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingFormType extends AbstractType
{
    private ManagerRegistry $managerRegistry;
    private Security $security;

    public function __construct(ManagerRegistry $managerRegistry, Security $security)
    {
        $this->security = $security;
        $this->managerRegistry = $managerRegistry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $em = $this->managerRegistry->getManager();
        $connectedUser = $this->security->getUser();
        $allAllergies = $em->getRepository(Allergy::class)->findAll();
        $userAllergies = null;
        $allergyChoices = null;
        if ($connectedUser != null) {
            $userInDB = $em->getRepository(User::class)->findOneBy(['email' => $connectedUser->getUserIdentifier()]);
            $userAllergies = $userInDB->getAllergies();
            $allergyChoices = array_diff($allAllergies, $this->getAllergiesName($userAllergies));
        }


        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom sur la commande'
            ])
            ->add('cutleryNumber', IntegerType::class, [
                'label' => 'Nombre de couverts'
            ])
            ->add('date', DateType::class, [
                'label' => 'Jour de réservation',
                'widget' => 'single_text'
            ])
            ->add('time', ChoiceType::class, [
                'label' => 'Horaires',
                'choices' => [],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('allergies', EntityType::class, [
                'class' => Allergy::class,
                'choices' => $allergyChoices != null ? $allergyChoices : $allAllergies,
                'label' => 'Ajouter une allergie ?',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class);

        $builder->get('time')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'validation_groups' => false,
        ]);
    }

    private function getAllergiesName(PersistentCollection $allergies): array
    {
        $finalArray = [];
        foreach ($allergies as $allergy) {
            $finalArray[] = $allergy->getName();
        }

        return $finalArray;
    }
}

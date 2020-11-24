<?php

namespace App\Form;

use App\Entity\Pot;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PotAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('Owner', ChoiceType::class, [
                "choices" => $options["Users"],
                "mapped" => false,
                "data" => $options["Selected_Owner"],
                'choice_value' => function (?User $User) {
                    return $User ? $User->getId() : '';
                },
                'choice_label' => function (User $user, $key, $value) {
                    return strtolower($user->getEmail() . " | " . $user->getUsername());
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pot::class,
            "Users" => [],
            "Selected_Owner" => 0
        ]);
    }
}

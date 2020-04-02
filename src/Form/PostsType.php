<?php

namespace App\Form;

use App\Entity\Posts;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Select file'
                ]
            ])
            ->add('title')
            ->add('description')
            ->add('zipCode')
            ->add('city')
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'email',
                'query_builder' => function (UsersRepository $usersRepository) {
                    return $usersRepository->createQueryBuilder('u');

                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
            'translation_domain' => 'forms'
        ]);
    }
}

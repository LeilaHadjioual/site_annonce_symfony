<?php

namespace App\Form;

use App\Entity\Posts;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image')
            ->add('title')
            ->add('description')
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'firstname',
                'query_builder' => function(UsersRepository $usersRepository){
                    return $usersRepository->createQueryBuilder('c');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
            'translation_domain' => 'forms'
        ]);
    }
}

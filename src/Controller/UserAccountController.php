<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserAccountController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
//        $this->usersRepository = $usersRepository;
    }

    /**
     * @Route("/user/{id}", name="my_account", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('userAccount/myAccount.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/login/new", name="new_account", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);;

        if ($form->isSubmitted() && $form->isValid()) {
            $role = 'ROLE_USER';
            $user->setRole($role);
            $password = $user->getPassword();
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Votre compte a été crée");


            return $this->redirectToRoute('app_login');
        }

        return $this->render('userAccount/createAccount.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/user/{id}/edit", name="account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $password = $user->getPassword();
//            $user->setPassword($this->encoder->encodePassword($user, $password));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Le compte utilisateur a été modifié");


            return $this->redirectToRoute('my_account', ['id' => $user->getId()]);
        }

        return $this->render('userAccount/editAccount.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/my-posts", name="my_posts", methods={"GET"})
     */
    public function getUserPosts(): Response
    {
        /** @var Users $user */
        $user = $this->getUser();

        return $this->render('usersPosts/index.html.twig', [
            'posts' => $user->getPosts()
        ]);
    }

}
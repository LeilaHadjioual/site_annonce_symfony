<?php


namespace App\Controller;


use App\DTO\UsersDto;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use App\Services\UsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserAccountController extends AbstractController
{
//    /**
//     * @var UserPasswordEncoderInterface
//     */
//    private $encoder;

    /**
     * @var UsersService
     */
    private $usersService;

    public function __construct(UsersService $usersService)
    {
//        $this->encoder = $encoder;
        $this->usersService = $usersService;
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
        $userDto = new UsersDto();
        $form = $this->createForm(UsersType::class, $userDto, ['validation_groups' => ['Default', 'add']]);
        $form->handleRequest($request);;

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Users();
            $this->usersService->addOrUpdate($userDto, $user);
            $this->addFlash('success', "Votre compte a été crée");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('userAccount/createAccount.html.twig', [
//            'user' => $user,
            'form' => $form->createView(),
            'isAdd' => true
        ]);
    }


    /**
     * @Route("/user/{id}/edit", name="account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        /**@var Users $user */
        $user = $this->getUser();
        $userDto = new UsersDto();
        $userDto->setFromEntity($user);

        $form = $this->createForm(UsersType::class, $userDto);
        $form->handleRequest($request);
        if ($userDto->password && $userDto->password !== $userDto->passwordConfirm) {
            $form->get('passwordConfirm')->addError(new FormError('Les mots de passe ne sont pas identiques'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->usersService->addOrUpdate($userDto, $user);
            $this->addFlash('success', "Le compte utilisateur a été modifié");

            return $this->redirectToRoute('my_account', ['id' => $user->getId()]);
        }

        return $this->render('userAccount/editAccount.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'isAdd' => false
        ]);
    }


    /**
     * @Route("/user/account/posts", name="user_posts", methods={"GET"})
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
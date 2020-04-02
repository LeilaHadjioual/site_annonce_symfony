<?php

namespace App\Controller\admin;

use App\DTO\UsersDto;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use App\Services\UsersService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminUsersController extends AbstractController
{

//    /**
//     * @var UserPasswordEncoderInterface
//     */
//    private $encoder;

    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * @var UsersRepository
     */
    private $usersRepository;

    public function __construct(UsersService $usersService, UsersRepository $usersRepository)
    {
//        $this->encoder = $encoder;
        $this->usersRepository =$usersRepository;
        $this->usersService = $usersService;

    }

    /**
     * @Route("/", name="users_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $this->usersRepository->findAll(),
            $request->query->getInt('page', 1),
            5);
        return $this->render('admin/users/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userDto = new UsersDto();
        $form = $this->createForm(UsersType::class, $userDto, ['validation_groups' => ['Default', 'add']]);
        $form->handleRequest($request);

        if ($userDto->password && $userDto->password !== $userDto->passwordConfirm) {
            $form->get('passwordConfirm')->addError(new FormError('Les mots de passes ne correspondent pas'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Users();
            $this->usersService->addOrUpdate($userDto, $user);
            $this->addFlash('success', "Le compte a été crée");

            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/new.html.twig', [
//            'user' => $user,
            'form' => $form->createView(),
            'isAdd' => true
        ]);
    }

    /**
     * @Route("/{id}", name="users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('admin/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="users_edit", methods={"GET","POST"})
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
            $form->get('passwordConfirm')->addError(new FormError('Les mots de passes ne correspondent pas'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->usersService->addOrUpdate($userDto, $user);
            $this->addFlash('success', "Le compte utilisateur a été modifié");

            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'isAdd' => false
        ]);
    }

    /**
     * @Route("/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }



        return $this->redirectToRoute('users_index');
    }
}

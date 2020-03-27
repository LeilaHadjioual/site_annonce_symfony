<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\UsersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class NewUserController extends AbstractController
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

            return $this->redirectToRoute('app_login');
        }

        return $this->render('userAccount/createAccount.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}
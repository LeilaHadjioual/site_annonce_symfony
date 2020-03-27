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


/**
 * @IsGranted("ROLE_USER")
 * @Route("/user")
 */
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
     * @Route("/{id}", name="my_account", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('userAccount/myAccount.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $password = $user->getPassword();
//            $user->setPassword($this->encoder->encodePassword($user, $password));
            $this->getDoctrine()->getManager()->flush();

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
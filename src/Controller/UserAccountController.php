<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/login")
 */
class UserAccountController extends AbstractController
{

    /**
     * @Route("/new", name="new_account", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
//        $user = new Users();
//        $form = $this->createForm(UsersType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('users_index');
//        }

        return $this->render('userAccount/createAccount.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
        ]);
    }

}
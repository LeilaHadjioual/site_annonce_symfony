<?php


namespace App\Controller;


use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/createPost")
 */
class UsersPostsController extends AbstractController
{
    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
//        $post = new Posts();
//        $form = $this->createForm(PostsType::class, $post);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($post);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('posts_index');
//        }

        return $this->render('usersPosts/createPost.html.twig', [
//            'post' => $post,
//            'form' => $form->createView(),
        ]);
    }
}
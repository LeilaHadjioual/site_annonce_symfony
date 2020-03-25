<?php


namespace App\Controller;


use App\Entity\Posts;
use App\Entity\Users;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/userPost")
 */
class UsersPostsController extends AbstractController
{
    /**
     * @Route("/myposts", name="my_posts", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('usersPosts/index.html.twig', [
//            'posts' => $postsRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="my_new_post", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('usersPosts/createPost.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

}
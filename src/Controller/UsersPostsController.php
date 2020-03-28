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
use Symfony\Component\Security\Core\User\User;


/**
 * @Route("/user/my_post")
 */
class UsersPostsController extends AbstractController
{
//    /**
//     * @Route("/myposts", name="my_posts", methods={"GET"})
//     */
//    public function index(): Response
//    {
//        return $this->render('usersPosts/index.html.twig', [
////            'posts' => $postsRepository->findAll(),
//        ]);
//    }


    /**
     * @Route("/new", name="my_new_post", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
//         $userId = $post->getUser();
//        $post->setUser($userId);

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


    /**
     * @Route("/{id}/edit", name="edit_post", methods={"GET","POST"})
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "L'annonce a été modifiée");

            return $this->redirectToRoute('my_posts');
        }

        return $this->render('usersPosts/editPost.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

}


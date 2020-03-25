<?php


namespace App\Controller;


use App\Entity\Posts;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetPostsController extends AbstractController
{

    /**
     * @var PostsRepository
     */
    private $postsRepository;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }


//    /**
//     * @Route("/",name="all-posts")
//     */
//    public function index(): Response
//    {
//        $posts = $this->postsRepository->findAll();
//        return $this->render('pages/allPosts.html.twig', ['posts' => $posts]);
//    }

//
//    /**
//     * @Route("/post/{id}", name="get_post", methods={"GET"})
//     */
//    function getById(Posts $post): Response
//    {
//        return $this->render('pages/detailsPost.html.twig', ['post' => $post]);
//    }
}
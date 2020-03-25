<?php


namespace App\Controller;


use App\Entity\Posts;
use App\Repository\PostsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var PostsRepository
     */
    private $postsRepository;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $this->postsRepository->findAll(),
            $request->query->getInt('page', 1),
            6);
//        $posts = $this->postsRepository->findAll();
        return $this->render('base.html.twig', [
            'posts' => $posts
        ]);
    }


    /**
     * @Route("/post/{id}", name="get_post", methods={"GET"})
     */
    function getById(Posts $post): Response
    {
        return $this->render('pages/detailsPost.html.twig', ['post' => $post]);
    }
}
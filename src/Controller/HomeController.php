<?php


namespace App\Controller;


use App\Entity\Posts;
use App\Repository\PostsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

//    /**
//     * @Route("/", name="home", methods={"GET"})
//     */
//    public function index(PaginatorInterface $paginator, Request $request): Response
//    {
//        $posts = $paginator->paginate(
//            $this->postsRepository->findAll(),
//            $request->query->getInt('page', 1),
//            5);
////        $posts = $this->postsRepository->findAll();
//        return $this->render('base.html.twig', [
//            'posts' => $posts
//        ]);
//    }


    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function handleSearch(Request $request, PaginatorInterface $paginator)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('home'))
            ->add('query', TextType::class)
            ->add('rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary search-icon'
                ]
            ])
            ->getForm();
        $query = $request->request->get('form')['query'];
        if (!$query) {
            $postsByquery = $this->postsRepository->findAll();

        } else {
            $postsByquery = $this->postsRepository->findByName($query);
        }
        $posts = $paginator->paginate(
            $postsByquery,
            $request->query->getInt('page', 1),
            5);
        return $this->render('base.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()]);


    }

    /**
     * @Route("/post/{id}", name="get_post", methods={"GET"})
     */
    function getById(Posts $post): Response
    {
        return $this->render('pages/detailsPost.html.twig', ['post' => $post]);
    }
}
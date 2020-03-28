<?php


namespace App\Controller;


use App\Entity\Posts;
use App\Entity\PostSearch;
use App\Form\PostSearchType;
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

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
//        $form = $this->createFormBuilder()
//            ->setAction($this->generateUrl('home'))
//            ->add('query', TextType::class)
//            ->add('rechercher', SubmitType::class, [
//                'attr' => [
//                    'class' => 'btn btn-primary'
//                ]
//            ])
//            ->getForm();
//        $query = $request->request->get('form')['query'];
//        if (!$query) {
//            $postsByquery = $this->postsRepository->findAll();
//
//        } else {
//            $postsByquery = $this->postsRepository->findByName($query);
//        }

        $search = new PostSearch();
        $form = $this->createForm(PostSearchType::class, $search);
        $form->handleRequest($request);

        $posts = $paginator->paginate(
            $this->postsRepository->findPostBySearch($search),
            $request->query->getInt('page', 1),
            5);

        return $this->render('pages/allPosts.html.twig', [
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
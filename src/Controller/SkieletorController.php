<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#	use App\Entity\Comment;
#	use App\Entity\Post;
#	use App\Events;
#	use App\Form\CommentType;
#	use App\Repository\PostRepository;
#	use App\Repository\TagRepository;
#	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
#	use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
#	use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
#	use Symfony\Component\EventDispatcher\EventDispatcherInterface;
#	use Symfony\Component\EventDispatcher\GenericEvent;
#	use Symfony\Component\HttpFoundation\Response;

class SkieletorController extends AbstractController
{
    /**
     * @Route("/skieletor", name="skieletor")
     */
    public function index()
    {
        return $this->render('skieletor/index.html.twig', [
            'the_title' => 'Skieletor',
        ]);
    }
	/**
     * @Route("/skieletor/login", name="login")
     */
    public function login()
    {
        return $this->render('skieletor/login.html.twig', [
            'the_title' => 'Skieletor',
        ]);
    }
	/**
     * @Route("/skieletor/home", name="home", methods={"POST",})
     */
    public function home(Request $request)
    {
		$flag = 'Ahtung';
		$post = false;
		
		$sos = $request->query->get('tekst1');
		if( $sos != true)
		{
			$flag = "Shaishe";
		}
		
        return $this->render('skieletor/index.html.twig', [
            'the_title' => $flag
        ]);
    }
}

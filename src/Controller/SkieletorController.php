<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\DBAL\Driver\Connection;

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
		$session = new Session;
		if($session->has('loged') == true)
		{
			return $this->home();	
		}
		else
		{
			return $this->render('skieletor/index.html.twig', [
				'the_title' => "Skieletor",
				'the_log' => "Login"
			]);
		}
    }
	
	/**
     * @Route("/skieletor/login", name="login")
     */
    public function login()
    {	
		$session = new Session;
		if($session->has('loged') == false)
		{
			return $this->render('skieletor/login.html.twig', 
				['the_title' => "Logowanie", 
				'the_log' => "Login"
			]);
		}
		else
		{
			$session->clear();
			return $this->render('skieletor/index.html.twig', 
				['the_title' => 'Wylogowałeś się', 
				'the_log' => "Logout"
			]);
		}
    }
	
	private function checkSLog($collapse)
	{
		$session = new Session;
		if($session->has('loged') == false)
		{
			return $this->render('skieletor/login.html.twig', ['the_title' => 'Logowanie', 'the_log' => "Login" ]);
		}
		else
		{
			return $collapse;
		}
	}
	/**
     * @Route("/skieletor/login_pass", name="login_pass", methods={"POST",})
     */
    public function login_pass(Request $request, Connection $connection)
    {
		$user_name = $request->request->get('user_name');
		$password = $request->request->get('password');
		
		$SQL = " SELECT user.id FROM user WHERE user.user = '$user_name' AND user.password = '$password' ";
		$ser = $connection->query($SQL);
		
		if($ser->rowCount() >= 1)
		{
			$ser = $ser->fetchAll();
			
			$session = new Session;
			$session->set('loged', 'true');
			$session->set('user_name', $user_name);
			$session->set('id_user', $ser[0]['id']);
			
			$connection->close();
			return $this->render('skieletor/game/home.html.twig', [
				'the_title' => "Small Farm",
				'the_log' => "Logout"
			]);
		}
		else
		{
			return $this->render('skieletor/login.html.twig', [
				'the_title' => "Niepowodzenie logowania",
				'the_log' => "Login"
			]);
		}
    }
	
	/**
     * @Route("/skieletor/home", name="home", methods={"POST",})
     */
    public function home()
	{
        return $this->render('skieletor/index.html.twig', [
            'the_title' => 'Jesteś zalogowany',
			'the_log' => "Logout"
		]);
    }
	/**
     * @Route("/skieletor/inventory", name="inventory")
     */
    public function inventory()
	{
        return $this->render('skieletor/game/inventory.html.twig', [
            'the_title' => 'Jesteś zalogowany',
			'the_log' => "Logout"
		]);
    }
	/**
     * @Route("/skieletor/registration", name="registration")
     */
    public function registration()
	{
        return $this->render('skieletor/registration.html.twig', [
            'the_title' => 'Jesteś zalogowany',
			'the_log' => "Logout"
		]);
    }
}

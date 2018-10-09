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

class SmallFarmController extends AbstractController
{
    /**
     * @Route("/SmallFarm", name="SmallFarm")
     */
    public function index(Connection $connection)
    {
		$session = new Session;
		if($session->has('loged') == true)
		{
			return $this->home($session, $connection);	
		}
		else
		{
			return $this->render('small_farm/index.html.twig', [
				'the_title' => "Small Farm",
				'the_log' => "Login"
			]);
		}
    }
    private function home($session, $connection)
	{	
		$id_user = $session->get('user_id');
		$SQL = "SELECT * FROM fields_user WHERE user_ID = '$id_user'";
		$res = $connection->query($SQL);
		$res = $res->fetchAll();
		
		
		$connection->close();
        return $this->render('small_farm/game/home.html.twig', [
            'the_title' => "Small Farm",
			'the_log' => "Logout",
			'the_res' => $res
		]);
    }
	
	/**
     * @Route("/SmallFarm/login", name="login")
     */
    public function login()
    {	
		$session = new Session;
		if($session->has('loged') == false)
		{
			return $this->render('small_farm/login.html.twig', 
				['the_title' => "Logowanie", 
				'the_log' => "Login"
			]);
		}
		else
		{
			$session->clear();
			return $this->render('small_farm/index.html.twig', 
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
			return $this->render('small_farm/login.html.twig', ['the_title' => 'Logowanie', 'the_log' => "Login" ]);
		}
		else
		{
			return $collapse;
		}
	}
	
	/**
     * @Route("/SmallFarm/login_pass", name="login_pass", methods={"POST",})
     */
    public function login_pass(Request $request, Connection $connection)
    {
		$user_name = $request->request->get('user_name');
		$password = $request->request->get('password');
		
		$SQL = " SELECT user_ID FROM user_game WHERE user_name = '$user_name' AND user_password = '$password' ";
		$ser = $connection->query($SQL);
		
		if($ser->rowCount() >= 1)
		{
			$ser = $ser->fetchAll();
			
			$session = new Session;
			$session->set('loged', 'true');
			$session->set('user_name', $user_name);
			$session->set('user_id', $ser[0]['user_ID']);
			
			$connection->close();
			
			return $this->index($connection);
		}
		else
		{
			return $this->render('small_farm/login.html.twig', [
				'the_title' => "Niepowodzenie logowania",
				'the_log' => "Login"
			]);
		}
    }
	/**
     * @Route("/SmallFarm/registration", name="registration")
     */
    public function registration()
	{
        return $this->render('small_farm/registration.html.twig', [
            'the_title' => 'Rejestracja',
			'the_log' => "Logout"
		]);
    }
	/**
     * @Route("/SmallFarm/adduser", name="adduser", methods={"POST",})
     */
    public function adduser(Request $request, Connection $connection)
	{
		$user_name = $request->request->get('user_name');
		$password_1 = $request->request->get('password');
		$email = $request->request->get('email');
		
		$connection->insert('user_game', ['user_name' => $user_name, 'user_password' => $password_1,
											'email' => $email, 'action_punkts' => '15',
											'lvl' => '1', 'experience' => '0',
											'silver_coins' => '10', 'gold_coins' => '1', 
											'premium_day' => '7'
										]);
		$this->setfield($connection, $user_name);
		
		$connection->close();
        return $this->render('small_farm/alert.html.twig', [
            'the_title' => 'Success',
			'the_log' => "Login",
			'the_alert' => "Zarejestrowałeś się"
		]);
    }
	private function setfield($connection, $user_name)
	{
		$SQL = "SELECT user_ID FROM user_game WHERE user_name = '$user_name';";
		$res = $connection->query($SQL);
		
		$res = $res->fetchAll();
		$user_id = $res[0]['user_ID'];
		
		$maps = [];
		for($i = 0; $i < 80; $i++)
		{
			$maps[$i] = 1;
		}
		
		for($i = 0; $i < 80; $i++)
		{
			$connection->insert('fields_user', ['user_ID' => $user_id, 'krotka_ID' => $i, 'content_ID' => $maps[$i], 'counter' => 0]);
		}
		return;
	}
	
	
	
	/**
     * @Route("/SmallFarm/inventory", name="inventory")
     */
    public function inventory()
	{
        return $this->render('small_farm/game/inventory.html.twig', [
            'the_title' => 'Jesteś zalogowany',
			'the_log' => "Logout"
		]);
    }
}

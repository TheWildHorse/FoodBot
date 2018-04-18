<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{

    /**
     * @Route(path="/login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getLogin()
    {
        return $this->render('auth/login.html.twig');
    }

}
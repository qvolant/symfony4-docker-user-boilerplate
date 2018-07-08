<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("/", name="security_")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
	{
    	$error = $utils->getLastAuthenticationError();
    	$lastUsername = $utils->getLastUsername();

        return $this->render('security/login.html.twig', [
        	'error' => $error,
			'last_username' => $lastUsername
		]);
    }

	/**
	 * @Route("/logout", name="logout")
	 */
	public function logout(): void
	{}
    
	/**
	 * @Route("/register", name="register")
	 */
	public function register(Request $request, UserPasswordEncoderInterface $encoder)
	{
		$user = new User();
		$form = $this->createForm(RegisterForm::class, $user);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$password = $encoder->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('security_login');
		}

		return $this->render('security/register.html.twig', [
			'form' => $form->createView()
		]);
    }
}

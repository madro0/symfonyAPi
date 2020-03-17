<?php

namespace App\Controller;


use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//para validar campos 
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\UserRepository;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */

      private $userRepository;

      public function __construct(UserRepository $userRepository)
      {
          $this->userRepository = $userRepository;
      }
  
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    
    public function add(Request $request ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        
        if(empty($email)||empty($password)){
            throw new NotFoundHttpException('pilas faltan algunos parametros o estan mas escribidos en el json');
        }

        $this->userRepository->saveUser($email, $password);

        return new JsonResponse(['status'=>'Excelente añadiste un nuevo usuarito!!!'], Response::HTTP_CREATED);
    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }

    
}

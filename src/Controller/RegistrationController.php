<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Security\Authenticator;
use App\Form\RegistrationFormType;
use App\Repository\MoviesFullRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(MoviesFullRepository $moviesFullRepository, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // function sortGenres($array)
        // {
        //     $arrayReturn = [];
        //     $i = 0;
        //     while ($i < count($array)) {
        //         foreach (explode(",", $array[$i]['genres']) as $key => $value) {
        //             array_push($arrayReturn, trim($value));
        //         }
        //         //dd(explode(",",$array[$i]['genres']));    


        //         $i++;
        //     }
        //     $arrayReturn = array_filter(array_unique($arrayReturn));
        //     sort($arrayReturn);

        //     $arrayReturn = array_values($arrayReturn);
        //     // dd($arrayReturn);
        // }


        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user, [
            "data" => $this->sortGenres($moviesFullRepository),
            "data_class" => null
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (
                $form->get('plainPassword')->getData() ===
                $form->get('confirmPassword')->getData()
            ) {
                $user->setRoles(['ROLE_USER']);
                $user->setCreatedAt(new DateTimeImmutable);
                $user->setGenre($form->get('genre')->getData());
                $user->setEmail($form->get('email')->getData());
                $user->setFirstName($form->get('firstname')->getData());
                $user->setLastName($form->get('lastname')->getData());

                //encode the plainPassword
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );


                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email

                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            }
            // encode the plain password

        } else {

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
                'passError' => "Les mots de passe ne sont pas indentiques",
            ]);
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    public static function sortGenres($moviesFullRepository)
    {
        $array = $moviesFullRepository->findGenres();
        $arrayReturn = [];
        $i = 0;
        while ($i < sizeof($array)) {
            foreach (explode(",", $array[$i]['genres']) as $key => $value) {
                array_push($arrayReturn, trim($value));
            }


            $i++;
        }
        $arrayReturn = array_filter(array_unique($arrayReturn));
        sort($arrayReturn);
        $lastArrayReturn = [];

        foreach ($arrayReturn as $key => $value) {
            $lastArrayReturn[$value] = $value;
        }

        $arrayReturn = array_values($arrayReturn);

        return $lastArrayReturn;
        // dd($arrayReturn);
    }
}

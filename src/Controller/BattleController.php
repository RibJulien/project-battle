<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BattleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        // ? Create Form
        $addPlayer = new Player();
        $addPlayerForm = $this->createFormBuilder($addPlayer)
            ->add('name', TextType::class, [
                'label' => 'Nom du joueur',
                'attr' => [
                    'class' => 'd-block w-75 mx-auto mb-2 form-control',
                    'placeholder' => 'e.g : Mark',
                    'minlength' => 2,
                    'maxlength' => 20
                    ],
                ])
            ->add('life', RangeType::class, [
                'label' => 'Points de vie',
                'attr' => [
                    'class' => 'd-block mx-auto w-75 mb-2',
                    'min' => 10,
                    'max' => 50,
                    'value' => 30
                    ]
                ])
            ->add('damage', RangeType::class, [
                'label' => 'Dégâts',
                'attr' => [
                    'class' => 'd-block mx-auto w-75 mb-2',
                    'min' => 1,
                    'max' => 5,
                    'value' => 3
                    ]
                ])
            ->add('initiative', RangeType::class, [
                'label' => 'Initiative',
                'attr' => [
                    'class' => 'd-block mx-auto w-75 mb-2',
                    'min' => 1,
                    'max' => 15,
                    'value' => 8
                    ]
                ])
            ->add('agility', RangeType::class, [
                'label' => 'Agilité',
                'attr' => [
                    'class' => 'd-block mx-auto w-75 mb-2',
                    'min' => 1,
                    'max' => 15,
                    'value' => 8
                    ]
                ])
            ->add('threat', RangeType::class, [
                'label' => 'Menace',
                'attr' => [
                    'class' => 'd-block mx-auto w-75 mb-2',
                    'min' => 1,
                    'max' => 15,
                    'value' => 8
                    ]
                ])
            ->add('img', ChoiceType::class, [
                'label' => 'Choisir une image pour votre joueur',
                'choices' => [
                    'warrior' => 'warrior.png',
                    'elf' => 'elf.png',
                    'old_wizard' => 'old_wizard.png',
                    'helmet' => 'helmet.png',
                    'wizard' => 'wizard.png',
                    'viking' => 'viking.png'
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'd-none']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();

        // ? Get result form + add to doctrine
        $addPlayerForm->handleRequest($request);
        if ($addPlayerForm->isSubmitted() && $addPlayerForm->isValid()) {
            // ? Stock data in a variable
            $data = $addPlayerForm->getData();

            $player = new Player();
            $entityManager = $doctrine->getManager();

            $player->setName($data->getName());
            $player->setLife($data->getLife());
            $player->setDamage($data->getDamage());
            $player->setInitiative($data->getInitiative());
            $player->setAgility($data->getAgility());
            $player->setThreat($data->getThreat());
            $player->setImg($data->getImg());
            
            $entityManager->persist($player);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre personnage a bien été ajouté !'
            );
        }

        // ? Fecth all players
        $players = $doctrine->getRepository(Player::class)->findAll();

        return $this->render('battle/index.html.twig', [
            'addPlayerForm' => $addPlayerForm->createView(),
            'players' => $players
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_player")
     */
    public function deletePlayer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $player = $entityManager->getRepository(Player::class)->find($id);

        // ? If player doesnt exist
        if (!$player) {
            $this->addFlash(
                'warning',
                'Erreur de suppression du joueur, il n\'a pas été trouvé en base de données.'
            );

            return $this->redirectToRoute('home');
        }
        
        $entityManager->remove($player);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le joueur a bien été supprimé.'
        );

        return $this->redirectToRoute('home');
    }
}

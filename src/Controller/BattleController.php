<?php

namespace App\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
    public function index(Request $request): Response
    {
        // ? Form Add Player
        $addPlayer = new Player();

        $addPlayerForm = $this->createFormBuilder($addPlayer)
            ->add('name', TextType::class, ['label' => 'Nom du joueur'])
            ->add('life', IntegerType::class, ['label' => 'Points de vie'])
            ->add('damage', IntegerType::class, ['label' => 'Dégâts'])
            ->add('initiative', IntegerType::class, ['label' => 'Initiative'])
            ->add('agility', IntegerType::class, ['label' => 'Agilité'])
            ->add('threat', IntegerType::class, ['label' => 'Menace'])
            ->add('img', ChoiceType::class, [
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
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
            ->getForm();


        return $this->render('battle/index.html.twig', [
            'addPlayerForm' => $addPlayerForm->createView()
        ]);
    }
}

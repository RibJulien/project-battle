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
                    'max' => 20,
                    'value' => 15
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

    /**
     * @Route("/combat", name="fight")
     */
    public function fight(ManagerRegistry $doctrine): Response
    {
        // ? Fetch player by initiative
        $playersObject = $doctrine->getRepository(Player::class)->findBy(
            [],
            ['initiative' => 'DESC']
        );

        // ? Send an error notification if there are less than 2 players
        if (count($playersObject) < 2 ) {
            $this->addFlash(
                'danger',
                'Il faut au minimum 2 joueurs pour pouvoir organiser un combat'
            );

            return $this->redirectToRoute('home');
        };

        // ? Convert player object to array + add teams
        $count = 0;
        $players = [];
        foreach ($playersObject as $i) {
            $players[$count]['id'] = $i->getId();
            $players[$count]['name'] = $i->getName();
            $players[$count]['life'] = $i->getLife();
            $players[$count]['damage'] = $i->getDamage();
            $players[$count]['initiative'] = $i->getInitiative();
            $players[$count]['agility'] = $i->getAgility();
            $players[$count]['threat'] = $i->getThreat();
            $players[$count]['img'] = $i->getImg();

            // ? Add player to team
            // ? Note : the first player will be team 1, and the second team 2 :
            // ? To prevent the case where all players are in the same team
            $players[$count]['team'] = rand(1,2);
            switch ($count) {
                case 0:
                    $players[$count]['team'] = 1;
                    break;
                case 1:
                    $players[$count]['team'] = 2;
                    break;
            }
            $count++;
        }

        // ? Game start
        $gameEnded = 0;
        $turn = 0;
        $summaryFight = [];
        while ($gameEnded != 1) {
            // ? Loop for every player's turn by initiative
            $turn++;
            $eachPlayersTurn = 0;
            foreach ($players as $playerTurn) {
                // ? If Player is still alive                
                if ($playerTurn['life'] > 0) {
                    $opponentsAlive = [];
                    $count = 0;

                    // ? Find alive opponents
                    foreach ($players as $i) {
                        if (($i['life'] > 0) && ($i['team'] !== $playerTurn['team'])) {
                            $opponentsAlive[$count] = $i;
                        }
                        $count++;
                    }

                    // ? Find target with threat calcul
                    $opponentsThreat = [];
                    $count = 0;
                    foreach ($opponentsAlive as $i) {
                        for ($j=0; $j < $i['threat']; $j++) { 
                            $opponentsThreat[$count] = $i;
                            $count++;
                        }
                    }
                    shuffle($opponentsThreat);
                    $target = $opponentsThreat[0];
                    // ? Calcul % touch (always between 50 and 100)
                    $hitCalcul = (int)(($playerTurn['agility']*100)/15/2+50);
                    // ? Player try to hit opponents
                    if (rand(1,100) < $hitCalcul) {
                        // ? Down life of target
                        $count = 0;
                        foreach ($players as $i) {
                            if ($i['id'] == $target['id']) {
                                $idTarget = $count;
                            } else {
                                $count++;
                            }
                        }
                        $summaryFight[$turn][$eachPlayersTurn] = "<span class='font-italic'>(".$playerTurn['team'].")".$playerTurn['name']."</span> <span class='hit'>inflige ".$playerTurn['damage']." de dégâts</span> à <span class='font-italic'>(".$target['team'].")".$target["name"]."</span>";
                        $players[$idTarget]['life'] -= $playerTurn['damage'];
                        
                        // ? Check if all ennemy are dead
                        $aliveOpponents = [];
                        $count = 0;
                        foreach ($players as $i) {
                            if ($i['team'] !== $playerTurn['team'] && $i['life'] > 0) {
                                $aliveOpponents[$count] = $i;
                                $count++;
                            }
                        }
                        if (count($aliveOpponents) < 1) {
                            $gameEnded = 1;
                            $winnerTeam = $playerTurn['team'];
                            $lastTurn = "(".$playerTurn['team'].")".$playerTurn['name']." permet à son équipe de remporter le combat grâce à cette ultime attaque !";
                            break;
                        }
                    } else {
                        $summaryFight[$turn][$eachPlayersTurn] = "<span class='font-italic'>(".$playerTurn['team'].")".$playerTurn['name']."</span> tente d'attaquer <span class='font-italic'>(".$target['team'].")".$target["name"]."</span>, mais ce dernier <span class='dodge'>arrive à equiver !</span>";
                    }
                }
                $eachPlayersTurn++;
            }
        }
        return $this->render('battle/fight.html.twig', [
            'winnerTeam' => $winnerTeam,
            'turn' => $turn,
            'summaryfights' => $summaryFight,
            'lastturn' => $lastTurn,
            'players' => $players
        ]);
    }
}
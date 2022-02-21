<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank (
     * message = "Le joueur doit avoir un nom"
     * )
     * @Assert\Length(
     * min = 2,
     * max = 20,
     * minMessage = "Le nom de votre joueur doit comporter au moins {{ limit }} caractères de long",
     * maxMessage = "Le nom de votre joueur doit comporter au maximum {{ limit }} caractères de long"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (
     * message = "Vous devez sélectionner le nombre de points de vie que votre joueur doit avoir"
     * )
     * @Assert\Range (
     * min = 10,
     * max = 50,
     * notInRangeMessage  = "Votre joueur doit avoir entre {{ min }} et {{ max }}  points de vie"
     * )
     */
    private $life;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (
     * message = "Vous devez sélectionner le nombre de dégâts que votre joueur doit avoir"
     * )
     * @Assert\Range(
     * min = 1,
     * max = 5,
     * notInRangeMessage  = "Votre joueur doit avoir entre {{ min }} et {{ max }} dégâts"
     * )
     */
    private $damage;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (
     * message = "Vous devez sélectionner l'initiative que votre joueur doit avoir"
     * )
     * @Assert\Range (
     * min = 1,
     * max = 15,
     * notInRangeMessage  = "Votre joueur doit avoir entre {{ min }} et {{ max }} initiative"
     * )
     */
    private $initiative;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (
     * message = "Vous devez sélectionner l'agilité que votre joueur doit avoir"
     * )
     * @Assert\Range (
     * min = 1,
     * max = 15,
     * notInRangeMessage  = "Votre joueur doit avoir entre {{ min }} et {{ max }} agilité"
     * )
     */
    private $agility;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank (
     * message = "Vous devez sélectionner la menace que votre joueur doit avoir"
     * )
     * @Assert\Range (
     * min = 1,
     * max = 15,
     * notInRangeMessage  = "Votre joueur doit avoir entre {{ min }} et {{ max }} menace"
     * )
     */
    private $threat;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank (
     * message = "Le joueur doit avoir une image"
     * )
     * @Assert\Length(
     * min = 2,
     * max = 20,
     * )
     */
    private $img;
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(int $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getInitiative(): ?int
    {
        return $this->initiative;
    }

    public function setInitiative(int $initiative): self
    {
        $this->initiative = $initiative;

        return $this;
    }

    public function getAgility(): ?int
    {
        return $this->agility;
    }

    public function setAgility(int $agility): self
    {
        $this->agility = $agility;

        return $this;
    }

    public function getThreat(): ?int
    {
        return $this->threat;
    }

    public function setThreat(int $threat): self
    {
        $this->threat = $threat;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }
}

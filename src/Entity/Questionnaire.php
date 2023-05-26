<?php

namespace App\Entity;

use App\Entity\Matiere;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionnaireRepository;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
class Questionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

   // "Oublié pendant le live :
    // #[ORM\Column(length: 255)]
    // cet oubli avait pour conséquence de ne pas générer la colonne matiere_id dans la table questionnaire
    // et donc de ne pas pouvoir faire le lien entre les deux entités
    // mais également de ne pas générer la contrainte de clé étrangère
    // Voir migration Version20230512173302.php
    
    #[ORM\ManyToOne(targetEntity: Matiere::class, inversedBy: 'questionnaires')]
    private ?Matiere $matiere = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    

   
   
}

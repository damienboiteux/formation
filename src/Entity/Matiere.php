<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\Timestampable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Matiere {
    
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 32)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Questionnaire::class)]
    private Collection $questionnaires;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $slug = null;

    // #[ORM\Column(nullable: true)]
    // private ?\DateTimeImmutable $createdAt = null;

    // #[ORM\Column(nullable: true)]
    // private ?\DateTimeImmutable $updatedAt = null;

    public function __construct() {
        $this->questionnaires = new ArrayCollection();
    }

    public function __toString(): string {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;
        return $this;
    }

    public function getQuestionnaires(): Collection {
        return $this->questionnaires;
    }


    public function addQuestionnaire(Questionnaire $questionnaire): self {
        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires[] = $questionnaire;
            $questionnaire->setMatiere($this);
        }
        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self {
        if ($this->questionnaires->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getMatiere() === $this) {
                $questionnaire->setMatiere(null);
            }
        }
        return $this;
    }

    // public function getCreatedAt(): ?\DateTimeImmutable
    // {
    //     return $this->createdAt;
    // }

    // public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }

    // public function getUpdatedAt(): ?\DateTimeImmutable
    // {
    //     return $this->updatedAt;
    // }

    // public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    // {
    //     $this->updatedAt = $updatedAt;

    //     return $this;
    // }

    // #[ORM\PrePersist]
    // public function prePersist(): void {
    //     $this->createdAt = new \DateTimeImmutable();
    //     $this->updatedAt = new \DateTimeImmutable();
    // }

    // #[ORM\PreUpdate]
    // public function preUpdate(): void {
    //     $this->updatedAt = new \DateTimeImmutable();
    // }

    // #[ORM\PrePersist]
    // #[ORM\PreUpdate]
    // public function prePersist(): void {
    //     if($this->createdAt === null) {
    //         $this->createdAt = new \DateTimeImmutable();
    //     }
    //     $this->updatedAt = new \DateTimeImmutable();
    // }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


}

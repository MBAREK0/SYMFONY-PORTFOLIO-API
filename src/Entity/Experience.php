<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_ORG_USER', fields: ['start_date', 'end_date', 'organization', 'user'])]
#[Vich\Uploadable]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $organization = null;

    #[ORM\Column(length: 255)]
    private ?string $role_en = null;

    #[ORM\Column(length: 255)]
    private ?string $role_fr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $responsibilities_en = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $responsibilities_fr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $achievements_en = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $achievements_fr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_en = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_fr = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[Vich\UploadableField(mapping: 'experience_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'experiences')]
    private Collection $technologies_used;

    #[ORM\ManyToOne(inversedBy: 'experiences')]
    private ?User $user = null;

    public function __construct()
    {
        $this->technologies_used = new ArrayCollection();
        $this->skills_developed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function getRoleEn(): ?string
    {
        return $this->role_en;
    }

    public function setRoleEn(?string $role_en): static
    {
        $this->role_en = $role_en;

        return $this;
    }

    public function getRoleFr(): ?string
    {
        return $this->role_fr;
    }

    public function setRoleFr(?string $role_fr): static
    {
        $this->role_fr = $role_fr;

        return $this;
    }

    public function getResponsibilitiesEn(): ?string
    {
        return $this->responsibilities_en;
    }

    public function setResponsibilitiesEn(?string $responsibilities_en): static
    {
        $this->responsibilities_en = $responsibilities_en;

        return $this;
    }

    public function getResponsibilitiesFr(): ?string
    {
        return $this->responsibilities_fr;
    }

    public function setResponsibilitiesFr(?string $responsibilities_fr): static
    {
        $this->responsibilities_fr = $responsibilities_fr;

        return $this;
    }

    public function getAchievementsEn(): ?string
    {
        return $this->achievements_en;
    }

    public function setAchievementsEn(?string $achievements_en): static
    {
        $this->achievements_en = $achievements_en;

        return $this;
    }

    public function getAchievementsFr(): ?string
    {
        return $this->achievements_fr;
    }

    public function setAchievementsFr(?string $achievements_fr): static
    {
        $this->achievements_fr = $achievements_fr;

        return $this;
    }

    public function getDescriptionEn(): ?string
    {
        return $this->description_en;
    }

    public function setDescriptionEn(?string $description_en): static
    {
        $this->description_en = $description_en;

        return $this;
    }

    public function getDescriptionFr(): ?string
    {
        return $this->description_fr;
    }

    public function setDescriptionFr(?string $description_fr): static
    {
        $this->description_fr = $description_fr;

        return $this;
    }


    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }


    /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
    */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getTechnologiesUsed(): Collection
    {
        return $this->technologies_used;
    }

    public function addTechnologiesUsed(Skill $technologiesUsed): static
    {
        if (!$this->technologies_used->contains($technologiesUsed)) {
            $this->technologies_used->add($technologiesUsed);
        }

        return $this;
    }

    public function removeTechnologiesUsed(Skill $technologiesUsed): static
    {
        $this->technologies_used->removeElement($technologiesUsed);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $stripePublicKey;

    #[ORM\Column(type: 'string', length: 255)]
    private string $stripePrivateKey;

    #[ORM\OneToOne(inversedBy: 'restaurant', targetEntity: Owner::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Owner $owner;

    /**
     * @var Collection<Menu>
     */
    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Menu::class)]
    private Collection $menus;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStripePublicKey(): ?string
    {
        return $this->stripePublicKey;
    }

    public function setStripePublicKey(string $stripePublicKey): self
    {
        $this->stripePublicKey = $stripePublicKey;

        return $this;
    }

    public function getStripePrivateKey(): ?string
    {
        return $this->stripePrivateKey;
    }

    public function setStripePrivateKey(string $stripePrivateKey): self
    {
        $this->stripePrivateKey = $stripePrivateKey;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setRestaurant($this);
        }

        return $this;
    }

//    public function removeMenu(Menu $menu): self
//    {
//        if ($this->menus->removeElement($menu)) {
//            // set the owning side to null (unless already changed)
//            if ($menu->getRestaurant() === $this) {
//                $menu->setRestaurant(null);
//            }
//        }
//
//        return $this;
//    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity("email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit avoir au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom ne doit pas avoir plus de {{ limit }} caractères",
     *      allowEmptyString = false
     *     )
     * @ORM\Column(type="string")
     */
    private $firstname;

    /**
     * * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Le nom doit avoir au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas avoir plus de {{ limit }} caractères",
     *      allowEmptyString = false
     *     )
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "cet email '{{ value }}' n'est pas valide"
     * )
     */
    private $email;

    /**
//     * @Assert\Regex("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $password;

    /**
     * @Assert\Regex("/^([0-9]{2} ){4}[0-9]{2}/")
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Posts", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Posts[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Posts $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}

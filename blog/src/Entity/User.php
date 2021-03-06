<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;


    /**
     * @ORM\Column(type="string", options={"default": "standart_avatar.png"})
     */
    private $image;

    /**
     * @ORM\Column(type="boolean", options={"default": 1})
     */
    private $isSubscribed = 1;


    public function __construct()
    {
        $this->isSubscriebed = 1;

    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }



    /**
     * @param $image
     * @return $this
     */
    public function setImage($image) : self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->username;
    }

    /**
     * @param string $username
     */
    public function setName(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="name")
     */
    private $comments;


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
//        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


/**
 * @return Collection|Comment[]
 */
public function getComments(): Collection
{
    return $this->comments;
}

public function addComment(Comment $comment): self
{
    if (!$this->comments->contains($comment)) {
        $this->comments[] = $comment;
        $comment->setName($this);
    }

    return $this;
}

public function removeComment(Comment $comment): self
{
    if ($this->comments->contains($comment)) {
        $this->comments->removeElement($comment);
        // set the owning side to null (unless already changed)
        if ($comment->getName() === $this) {
            $comment->setName(null);
        }
    }

    return $this;
}

    public function getIsSubscribed(): ?bool
    {
        return $this->isSubscribed;
    }

    public function setIsSubscribed(bool $isSubscribed): self
    {
        $this->isSubscribed = $isSubscribed;

        return $this;
    }

    public function getAllRoles() : array
    {
        return [
            'ROLE_USER',
            'ROLE_ADMIN',
        ];
    }

}


//    public function setUsername(string $username): ?string
//    {
//        $this->username = $username;
//
//        return $this;
//    }
//
//    public function getUsername(): string
//    {
//        return (string) $this->username;
//    }

//public function getIsSubscriebed(): ?bool
//{
//    return $this->isSubscriebed;
//}

//public function setIsSubscriebed(bool $isSubscriebed): self
//{
//    $this->is_subscriebed = $isSubscriebed;
//
//    return $this;
//}

//    /**
//     * @see UserInterface
//     */
//    public function getName(): string
//    {
//        return (string) $this->username;
//    }
//
//    public function setName(string $username): self
//    {
//        $this->username = $username;
//
//        return $this;
//    }
//    /**
//     * @ORM\Column(type="boolean", {"default": 1})
//     */
//    private $isSubscriebed;

//    public function __toString()
//    {
//        return $this->image;
//    }
//

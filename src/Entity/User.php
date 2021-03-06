<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 * @UniqueEntity("email")
 */
class User implements UserInterface, \JsonSerializable {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=180)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank
     * @var string[]
     */
    private $roles = [ "ROLE_USER" ];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     * @Assert\Type(type={"alpha"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     * @Assert\Type(type={"alpha"})
     */
    private $last_name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Positive()
     * @Assert\Type(type={"integer"})
     */
    private $age;

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail( string $email ): self {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUsername(): string {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique( $roles );
    }

    public function setRoles( array $roles ): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword( string $password ): self {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     * @see UserInterface
     */
    public function getSalt(): ?string {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string {
        return $this->first_name;
    }

    public function setFirstName( string $first_name ): self {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->last_name;
    }

    public function setLastName( string $last_name ): self {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAge(): ?int {
        return $this->age;
    }

    public function setAge( int $age ): self {
        $this->age = $age;

        return $this;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'age' => $this->age,
        ];
    }
}

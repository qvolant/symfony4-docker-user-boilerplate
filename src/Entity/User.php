<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="accounts")
 */
class User implements UserInterface, \Serializable
{
    /**
	 * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
	 * @var string
     * @ORM\Column(type="string", length=255, unique=true)
	 * @Assert\NotBlank()
     */
    private $username;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;

    /**
	 * @var string
     * @ORM\Column(type="string", length=255, unique=true)
	 * @Assert\NotBlank()
	 * @Assert\Email()
     */
    private $email;

    /**
	 * @var array
     * @ORM\Column(type="array")
     */
    private $roles;

	/**
	 * @var string
	 * @Assert\NotBlank()
	 * @Assert\Length(max=4096)
	 */
	private $plainPassword;

	/**
	 * User constructor.
	 */
	public function __construct() {
		$this->roles = ['USER'];
    }

	/**
	 * @return string|null
	 */
	public function __toString(): ?string
	{
		return $this->username;
	}


	/**
	 * @return null|int
	 */
	public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return null|string
	 */
	public function getUsername(): ?string
    {
        return $this->username;
    }

	/**
	 * @param string $username
	 * @return User
	 */
	public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

	/**
	 * @return null|string
	 */
	public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

	/**
	 * @param string $password
	 * @return User
	 */
	public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

	/**
	 * @return null|string
	 */
	public function getPassword(): ?string
    {
        return $this->password;
    }

	/**
	 * @param string $password
	 * @return User
	 */
	public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

	/**
	 * @return null|string
	 */
	public function getEmail(): ?string
    {
        return $this->email;
    }

	/**
	 * @param string $email
	 * @return User
	 */
	public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

	/**
	 * Returns the roles granted to the user.
	 * @return array
	 */
	public function getRoles(): array {
		return $this->roles;
	}

	/**
	 * Returns true is a user has a specific role, false instead
	 * @param string $role
	 * @return bool
	 */
	public function hasRole(string $role): bool
	{
		return \in_array(strtoupper($role), $this->roles, true);
	}

	/**
	 * Add a role to the user.
	 * @param string $role
	 * @return User
	 */
	public function addRole(string $role): self
	{
		$role = strtoupper($role);
		if (!\in_array($role, $this->roles, true)) {
			$this->roles[] = $role;
		}
		return $this;
	}

	/**
	 * Remove a role from the user.
	 * @param string $role
	 * @return User
	 */
	public function removeRole(string $role): self
	{
		$role = strtoupper($role);
		$this->roles[] = array_diff($this->roles, [$role]);
		return $this;
	}

	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string|null
	 */
	public function getSalt(): ?string {
		return null;
	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 *
	 * @return bool|null
	 */
	public function eraseCredentials(): ?bool {
		return null;
	}

	/**
	 * @return string
	 */
	public function serialize(): string {
		return serialize([
			$this->id,
			$this->username,
			$this->email,
			$this->password
		]);
	}

	/**
	 * @param string $serialized
	 * @return array
	 */
	public function unserialize($serialized): array {
		return [
			$this->id,
			$this->username,
			$this->email,
			$this->password
		] = unserialize($serialized, ['allowed_classes' => false]);
	}
}

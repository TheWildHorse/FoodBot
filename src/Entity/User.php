<?php

namespace App\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $slackId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="user", orphanRemoval=true)
     */
    private $orderItems;

    /**
     * @ORM\Column(type="decimal", precision=8)
     */
    private $moneyBalance = 0;

    /**
     * @ORM\Column(type="json_array")
     */
    private $favourites = [];

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlackId()
    {
        return $this->slackId;
    }

    /**
     * @param mixed $slackId
     * @return User
     */
    public function setSlackId($slackId)
    {
        $this->slackId = $slackId;
        return $this;
    }




    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getName();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * @return mixed
     */
    public function getMoneyBalance()
    {
        return $this->moneyBalance;
    }

    /**
     * @param mixed $moneyBalance
     * @return User
     */
    public function setMoneyBalance($moneyBalance)
    {
        $this->moneyBalance = $moneyBalance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFavourites()
    {
        return $this->favourites;
    }

    /**
     * @param mixed $favourites
     * @return User
     */
    public function setFavourites($favourites)
    {
        $this->favourites = $favourites;
        return $this;
    }

}

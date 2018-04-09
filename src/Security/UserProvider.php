<?php


namespace App\Security;


use App\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use RuntimeException;

class UserProvider extends EntityUserProvider
{

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        $username = $response->getUsername();
        if (null === $user = $this->findUser(array($this->properties[$resourceOwnerName] => $username))) {
            $user = new User();
            $user->setName($response->getNickname());
            $user->setEmail($response->getEmail());
            $user->setSlackId($username);
            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }

        return $user;
    }

}
<?php

namespace App\Security\Credential;

use Study\Credential\Domain\Repository\CredentialRepository;
use Study\User\Domain\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CredentialProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    /** @var CredentialRepository */
    protected $credentialRepository;

    public function __construct(CredentialRepository $credentialRepository)
    {
        $this->credentialRepository = $credentialRepository;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $credential = $this->credentialRepository->bykey($username);
        if (!$credential) {
            throw new UsernameNotFoundException(sprintf('No Credential found for the given key'));
        }

        return new Credential($credential);
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user)
    {

        if (!$user instanceof Credential) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        $freshCredential = $this->credentialRepository->byKey($user->getUsername());
        if (!$freshCredential) {
            throw new UsernameNotFoundException(sprintf('Given credential not found for refresh'));
        }

        return new Credential($freshCredential);
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === Credential::class;
    }

    /**
     * Upgrades the encoded password of a user, typically for using a better hash algorithm.
     *
     * This method should persist the new password in the user storage and update the $user object accordingly.
     * Because you don't want your users not being able to log in, this method should be opportunistic:
     * it's fine if it does nothing or if it fails without throwing any exception.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Credential) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $credential->credential()->setKey($newEncodedPassword);
    }
}
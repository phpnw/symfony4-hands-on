<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity()
 */
class User implements UserInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true, length=100)
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string", nullable=false, length=100)
     *
     * @var string
     */
    private $hashedPassword;

    /**
     * User constructor.
     * @param string $username
     */
    public function __construct(string $username, string $hashedPassword)
    {
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return $this->getHashedPassword();
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @param string $hashedPassword
     * @return User
     */
    public function setHashedPassword(string $hashedPassword): User
    {
        $this->hashedPassword = $hashedPassword;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}

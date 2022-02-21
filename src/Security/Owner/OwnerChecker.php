<?php

declare(strict_types=1);

namespace App\Security\Owner;

use App\Entity\Owner;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class OwnerChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $owner): void
    {
        if (!$owner instanceof Owner) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $owner)
    {
        /** @var $owner Owner */
        if (false === $owner->getIsVerified()) {
            throw new UnsupportedUserException('Veuillez vérifier votre email');
        }
    }
}

<?php

namespace App\Security\Voter;

use App\Entity\Game;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GameVoter extends Voter
{
    public const VIEW = 'view';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
            && $subject instanceof Game;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Game $game */
        $game = $subject;

        return match($attribute) {
            self::VIEW => $this->canView($game, $user),
            self::EDIT => $this->canEdit($game, $user),
            self::DELETE => $this->canDelete($game, $user),
            default => false,
        };
    }

    private function canView(Game $game, User $user): bool
    {
        // Teachers can view their own games, admins can view all
        return $game->getCreator() === $user || in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canEdit(Game $game, User $user): bool
    {
        // Teachers can edit their own games, admins can edit all
        return $game->getCreator() === $user || in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canDelete(Game $game, User $user): bool
    {
        // Teachers can delete their own games, admins can delete all
        return $game->getCreator() === $user || in_array('ROLE_ADMIN', $user->getRoles());
    }
}

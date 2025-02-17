<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TaskVoter extends Voter
{
    public const EDIT = 'TASK_EDIT';
    public const VIEW = 'TASK_VIEW';
    public const DELETE = 'TASK_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** var Task $task */
        $task = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::VIEW:
                return $this->canView($task, $user);
            case seld::DELETE:
                return $this->canDelete($task, $user);
        }

        return false;
    }

    private function canView(Task $task, UserInterface $user): bool
    {
        // Un usuario puede ver una tarea si es el propietario
        return $task->getUser() === $user;
    }

    private function canEdit(Task $task, UserInterface $user): bool
    {
        // Un usuario puede editar una tarea si es el propietario
        return $task->getUser() === $user;
    }

    private function canDelete(Task $task, UserInterface $user): bool
    {
        // Un usuario puede eliminar una tarea si es el propietario
        return $task->getUser() === $user;
    }

}

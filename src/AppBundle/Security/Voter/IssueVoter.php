<?php

namespace AppBundle\Security\Voter;

use AppBundle\Entity\Issue;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * IssueVoter.
 *
 * @author Wolfgang Gassner <gassnerw@gmail.com>
 */
class IssueVoter extends Voter
{
    /**
     * Supported attributes.
     */
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::EDIT, self::DELETE))) {
            return false;
        }

        if (!$subject instanceof Issue) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // Admins have the ultimate power.
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);

            // Currently only admins may delete an issue.
            case self::DELETE:
                return false;
        }

        throw new \LogicException(sprintf('Error: Attribute "%s" is not supported!', $attribute));
    }

    /**
     * Only creators or admins may edit an issue.
     *
     * @param Issue $issue
     * @param User $user
     * @return bool
     */
    private function canEdit(Issue $issue, User $user)
    {
        return $user === $issue->getCreator();
    }
} 
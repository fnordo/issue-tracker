<?php

namespace AppBundle\DataFixtures\Faker\Provider;

use AppBundle\Entity\Issue;

/**
 * IssueProvider.
 *
 * @author Wolfgang Gassner <gassnerw@gmail.com>
 */
class IssueProvider
{
    /**
     * @var array Available issue statuses.
     */
    protected static $statuses = array(
        Issue::STATUS_OPEN, Issue::STATUS_CLOSED
    );

    /**
     * Randomly set issue status.
     *
     * @return mixed
     */
    public static function status()
    {
        return self::$statuses[array_rand(self::$statuses)];
    }
} 
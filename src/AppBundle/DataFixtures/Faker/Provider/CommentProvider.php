<?php

namespace AppBundle\DataFixtures\Faker\Provider;

use Faker\Provider\Lorem;

/**
 * CommentProvider.
 *
 * @author Wolfgang Gassner <gassnerw@gmail.com>
 */
class CommentProvider
{
    /**
     * Randomly set body.
     *
     * @param int $nbSentences
     * @param bool $variableNbSentences
     * @return mixed
     */
    public static function body($nbSentences = 3, $variableNbSentences = true)
    {
        return Lorem::paragraph($nbSentences, $variableNbSentences);
    }
} 
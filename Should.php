<?php namespace Laradic\Dev;

    /**
     * Part of the Radic packges.
     * Licensed under the MIT license.
     *
     * @package        dev9
     * @author         Robin Radic
     * @license        MIT
     * @copyright  (c) 2011-2015, Robin Radic
     * @link           http://radic.mit-license.org
     */
/**
 * Should
 *
 * @package Laradic\Dev${NAME}
 */

class Should extends TestFacade
{

    protected $aliases = array(
        'have' => 'assertContains',
        'eq'   => 'assertEquals'
    );

    protected function getMethod($methodName)
    {
        // If an alias is registered,
        // that takes precendence.
        if ($this->isAnAlias($methodName))
        {
            return $this->aliases[$methodName];
        }
        // If the method begins with "be" or "have," then strip
        // that off. The remainder is the correct assertion name.
        // beTrue => True ... haveCount => Count
        else
        {
            if (preg_match('/^(?:be|have)(.+)$/i', $methodName, $matches))
            {
                return 'assert' . ucwords($matches[1]);
            }
        }
        // If all else fails, just pluralize the word
        // equal => assertEquals
        return 'assert' . ucwords($methodName) . 's';
    }
}

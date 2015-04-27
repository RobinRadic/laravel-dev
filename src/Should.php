<?php
/**
 * Part of the Robin Radic's PHP packages.
 *
 * MIT License and copyright information bundled with this package
 * in the LICENSE file or visit http://radic.mit-license.com
 */
namespace Laradic\Dev;

/**
 * This is the Should class.
 *
 * @package        Dev
 * @version        1.0.0
 * @author         Robin Radic
 * @license        MIT License
 * @copyright      2015, Robin Radic
 * @link           https://github.com/robinradic
 */
class Should extends AbstractTestFacadeCase
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

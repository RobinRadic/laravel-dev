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
 * Assert
 *
 * @package Laradic\Dev${NAME}
 */
class Assert extends AbstractTestFacadeCase
{

    protected $aliases = array(
        'eq'       => 'assertEquals',
        'has'      => 'assertContains',
        'type'     => 'assertInternalType',
        'instance' => 'assertInstanceOf'
    );

    protected function getMethod($methodName)
    {
        // If an alias is registered,
        // that takes precendence.
        if ($this->isAnAlias($methodName))
        {
            return $this->aliases[$methodName];
        }


        return 'assert' . ucwords($methodName);

    }
}

<?php
/**
 * This file is part of the sauls/collections package.
 *
 * @author    Saulius Vaičeliūnas <vaiceliunas@inbox.lt>
 * @link      http://saulius.vaiceliunas.lt
 * @copyright 2018
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sauls\Component\Collection;

use Sauls\Component\Collection\Exception\UnsupportedOperationException;

class ImmutableArrayCollection extends ArrayCollection
{
    public function __construct($elements = null)
    {
        $this->assign((new ArrayCollection($elements))->all());
    }
    
    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function set($key, $value): void
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function add(array $elements): void
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function merge(array $elements): void
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function replace(array $elements): void
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function clear(): void
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function removeKey($key)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function removeValue($element)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function unserialize($value): void
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function map(\Closure $function)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function offsetSet($offset, $value)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * @throws \Sauls\Component\Collection\Exception\UnsupportedOperationException
     */
    public function offsetUnset($offset)
    {
        throw new UnsupportedOperationException();
    }
}

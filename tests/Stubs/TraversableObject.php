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

namespace Sauls\Component\Collection\Stubs;


use Traversable;

class TraversableObject implements \IteratorAggregate
{

    public function getIterator()
    {
        return new \ArrayIterator(['test' => '24']);
    }
}

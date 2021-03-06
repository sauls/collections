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

use Sauls\Component\Collection\Arrayable;

class SimpleObject implements Arrayable
{
    public $property1 = 'prop1';

    public function toArray(): array
    {
        return [
            'property1' => $this->property1,
        ];
    }
}

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

use function \Sauls\Component\Helper\array_merge;
use PHPUnit\Framework\TestCase;

class ArrayCollectionTestCase extends TestCase
{
    public function createArrayCollection(array $elements = [])
    {
        return new ArrayCollection($elements);
    }

    public function getTestArray(array $elements = []): array
    {
        return array_merge([
            'key1' => 1,
            'key2' => [
                'x' => [
                    'p1' => 1,
                    'p2' => 22,
                ],
                'z' => [
                    'v' => 11
                ]
            ],
            'key3' => 1,
            'key6' => 1,
        ], $elements);
    }
}

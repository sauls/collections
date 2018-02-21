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

use function Sauls\Component\Helper\register_converters;
use Sauls\Component\Collection\Converter;

register_converters([
    new Converter\CollectionToArrayConverter,
    new Converter\ArrayableToArrayConverter
]);

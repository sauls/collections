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

namespace Sauls\Component\Collection\Converter\Type;

use Sauls\Component\Collection\Collection;
use Sauls\Component\Helper\Operation\TypeOperation\Converter\ConverterInterface;

class CollectionToArrayConverter implements ConverterInterface
{
    /**
     * @param Collection $value
     */
    public function convert($value): array
    {
        return $value->all();
    }

    public function supports($value): bool
    {
        return is_subclass_of($value, Collection::class);
    }

    public function getType(): string
    {
        return 'array';
    }

    public function getPriority(): int
    {
        return 1024;
    }
}

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

use Sauls\Component\Collection\Arrayable;
use Sauls\Component\Helper\Operation\TypeOperation\Converter\ConverterInterface;

class ArrayableToArrayConverter implements ConverterInterface
{
    public function convert($value): array
    {
        return $value->toArray();
    }

    public function supports($value): bool
    {
        return is_subclass_of($value, Arrayable::class);
    }

    public function getType(): string
    {
        return 'array';
    }

    public function getPriority(): int
    {
        return 512;
    }
}

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

namespace Sauls\Component\Collection\Converter;

use function Sauls\Component\Helper\convert_to;
use PHPUnit\Framework\TestCase;
use Sauls\Component\Collection\ArrayCollection;
use Sauls\Component\Collection\Converter\Type\ArrayableToArrayConverter;
use Sauls\Component\Collection\Converter\Type\CollectionToArrayConverter;
use Sauls\Component\Collection\Stubs\SimpleObject;

class ConvertersTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_collection_to_array_converter(): void
    {
        $arrayCollection = new ArrayCollection(['test']);
        $collectionToArrayConverter = new CollectionToArrayConverter;

        $this->assertSame(['test'], $collectionToArrayConverter->convert($arrayCollection));
        $this->assertSame(['test'], convert_to($arrayCollection, 'array'));
        $this->assertTrue($collectionToArrayConverter->supports($arrayCollection));
        $this->assertSame('array', $collectionToArrayConverter->getType());
        $this->assertSame(1024, $collectionToArrayConverter->getPriority());
    }

    /**
     * @test
     */
    public function should_create_arrayable_to_array_converter(): void
    {
        $simpleObject = new SimpleObject;
        $arrayableToArrayConverter = new ArrayableToArrayConverter;

        $this->assertSame(['property1' => 'prop1'], $arrayableToArrayConverter->convert($simpleObject));
        $this->assertSame(['property1' => 'prop1'], convert_to($simpleObject, 'array'));
        $this->assertTrue($arrayableToArrayConverter->supports($simpleObject));
        $this->assertSame('array', $arrayableToArrayConverter->getType());
        $this->assertSame(512, $arrayableToArrayConverter->getPriority());
    }
}

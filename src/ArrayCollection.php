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

use function Sauls\Component\Helper\array_deep_search;
use function Sauls\Component\Helper\array_get_value;
use function Sauls\Component\Helper\array_remove_key;
use function Sauls\Component\Helper\array_remove_value;
use function Sauls\Component\Helper\array_merge;
use function \Sauls\Component\Helper\array_key_exists;
use function Sauls\Component\Helper\array_set_value;
use Sauls\Component\Helper\Exception\PropertyNotAccessibleException;

class ArrayCollection implements ArrayCollectionInterface
{
    /**
     * @var array
     */
    private $elements;

    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function create(array $elements): ArrayCollectionInterface
    {
        return new static($elements);
    }

    public function set($key, $value): void
    {
        array_set_value($this->elements, $key, $value);
    }

    public function add(array $elements): void
    {
        foreach($elements as $key => $element) {
            $this->set($key, $element);
        }
    }

    public function merge(array $elements): void
    {
        $this->elements = array_merge($this->elements, $elements);
    }

    /**
     * @throws PropertyNotAccessibleException
     */
    public function get($key, $default = null)
    {
        return array_get_value($this->elements, $key, $default);
    }

    public function replace(array $elements): void
    {
        $this->elements = $elements;
    }

    public function removeKey($key)
    {
        return array_remove_key($this->elements, $key, false);
    }

    public function removeElement($element)
    {
        return array_remove_value($this->elements, $element);
    }

    public function slice($offset, $length = null): array
    {
        return \array_slice($this->elements, $offset, $length, true);
    }

    public function clear(): void
    {
        $this->elements = [];
    }

    public function all(): array
    {
        return $this->elements;
    }

    public function filter(\Closure $function)
    {
        return \array_filter($this->elements, $function, ARRAY_FILTER_USE_BOTH);
    }

    public function map(\Closure $function)
    {
        return \array_map($function, $this->elements);
    }

    public function hasKey($key): bool
    {
        return array_key_exists($this->elements, $key);
    }

    public function hasElement($element): bool
    {
        return empty(array_deep_search($this->elements, $element)) ? false : true;
    }

    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    public function __toString(): string
    {
        return __CLASS__ . '@' . spl_object_hash($this);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    public function offsetExists($offset)
    {
        return $this->hasKey($offset);
    }

    /**
     * @throws PropertyNotAccessibleException
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->removeKey($offset);
    }

    public function count(): int
    {
        return \count($this->elements);
    }
}

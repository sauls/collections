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
use function Sauls\Component\Helper\array_key_exists;
use function Sauls\Component\Helper\array_set_value;
use function Sauls\Component\Helper\array_keys;
use function Sauls\Component\Helper\convert_to;

class ArrayCollection implements Collection, \JsonSerializable
{
    /**
     * @var array
     */
    private $elements = [];

    public function __construct($elements = null)
    {
        $this->add(convert_to($elements, 'array'));
    }

    public static function create(array $elements): Collection
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

    public function get($key, $default = null)
    {
        return array_get_value($this->elements, $key, $default);
    }

    public function replace(array $elements): void
    {
        $this->clear();
        $this->add($elements);
    }

    public function removeKey($key)
    {
        return array_remove_key($this->elements, $key, false);
    }

    public function removeValue($element)
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

    public function filter(\Closure $function): Collection
    {
        return static::create(\array_filter($this->elements, $function, ARRAY_FILTER_USE_BOTH));
    }

    public function map(\Closure $function): Collection
    {
        return static::create(\array_map($function, $this->elements));
    }

    public function keyOrValueExists($keyOrValue): bool
    {
        if ($this->keyExists($keyOrValue)) {
            return true;
        }

        return $this->valueExists($keyOrValue);
    }

    public function keyOrValueDoesNotExist($keyOrValue): bool
    {
        return false === $this->keyOrValueExists($keyOrValue);
    }

    public function keyExists($key): bool
    {
        return array_key_exists($key, $this->elements);
    }

    public function keyDoesNotExist($key): bool
    {
        return false === $this->keyExists($key);
    }

    public function valueExists($value): bool
    {
        return empty(array_deep_search($this->elements, $value)) ? false : true;
    }

    public function valueDoesNotExist($value): bool
    {
        return false === $this->valueExists($value);
    }

    public function valueIsNull($key): bool
    {
        return null === $this->get($key);
    }

    public function valueIsNotNull($key): bool
    {
        return false === $this->valueIsNull($key);
    }

    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    public function __toString(): string
    {
        return __CLASS__ . '#' . $this->getHash();
    }

    public function getHash(): string
    {
        return md5(\serialize($this->elements));
    }

    public function getSplHash(): string
    {
        return \spl_object_hash($this);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    public function offsetExists($offset)
    {
        return $this->keyExists($offset);
    }

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

    public function keys(): Collection
    {
        return static::create(array_keys($this->elements));
    }

    protected function assign(array $elements): void
    {
        $this->elements = $elements;
    }

    public function jsonSerialize(): array
    {
        return $this->all();
    }
}

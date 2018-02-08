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

interface ArrayCollectionInterface extends \Countable, \ArrayAccess, \IteratorAggregate
{
    public function create(array $elements): ArrayCollectionInterface;
    public function set($key, $value): void;
    public function add(array $elements): void;
    public function get($key, $default = null);
    public function merge(array $elements): void;
    public function replace(array $elements): void;
    public function removeKey($key);
    public function removeElement($element);
    public function slice($offset, $length = null): array;
    public function clear(): void;
    public function all(): array;
    public function filter(\Closure $function);
    public function map(\Closure $function);
    public function hasKey($key): bool;
    public function hasElement($element): bool;
    public function isEmpty(): bool;
    public function __toString(): string;
}

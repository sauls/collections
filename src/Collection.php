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

interface Collection extends \Countable, \ArrayAccess, \IteratorAggregate
{
    public static function create(array $elements): Collection;
    public function set($key, $value): void;
    public function add(array $elements): void;
    public function get($key, $default = null);
    public function merge(array $elements): void;
    public function replace(array $elements): void;
    public function removeKey($key);
    public function removeValue($element);
    public function slice($offset, $length = null): array;
    public function clear(): void;
    public function all(): array;

    public function filter(\Closure $function): Collection;
    public function keys(): Collection;
    public function map(\Closure $function): Collection;

    public function keyOrValueExists($keyOrValue): bool;
    public function keyOrValueDoesNotExists($keyOrValue): bool;
    public function keyExist($key): bool;
    public function keyDoesNotExist($key): bool;
    public function valueExist($value): bool;
    public function valueDoesNotExist($value): bool;
    public function valueIsNull($key): bool;
    public function valueIsNotNull($key): bool;
    public function isEmpty(): bool;

    public function __toString(): string;
    public function getHash(): string;
    public function getSplHash(): string;
}

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

use Sauls\Component\Collection\Exception\UnsupportedOperationException;
use Sauls\Component\Collection\Stubs\SimpleObject;
use Sauls\Component\Collection\Stubs\TraversableObject;
use function Sauls\Component\Helper\array_multiple_keys_exists;
use Sauls\Component\Helper\Exception\PropertyNotAccessibleException;

class ArrayCollectionTest extends ArrayCollectionTestCase
{
    /**
     * @test
     */
    public function should_assure_that_passed_variable_is_array()
    {
        $this->assertSame([], (new ArrayCollection([]))->all());
        $this->assertSame([0 => 'test'], (new ArrayCollection('test'))->all());
        $this->assertSame([0 => 1], (new ArrayCollection(1))->all());
        $this->assertSame([0 => 1], (new ArrayCollection([1]))->all());
        $this->assertSame(['test' => '24'], (new ArrayCollection(new TraversableObject()))->all());
    }

    /**
     * @test
     */
    public function should_create_array_collection()
    {
        $arrayCollection = $this->createArrayCollection();

        $newArrayCollection = $arrayCollection->create([
            'new' => 'key',
            'test' => 11,
            0 => 4,
        ]);

        $this->assertInstanceOf(Collection::class, $newArrayCollection);
    }

    /**
     * @test
     */
    public function should_set_array_value()
    {
        $arrayCollection = $this->createArrayCollection();

        $arrayCollection->set('test', 11);
        $arrayCollection->set('test.nested.key', 11);

        $this->assertTrue($arrayCollection->keyExists('test'));
        $this->assertSame(11, $arrayCollection->get('test.nested.key'));
    }

    /**
     * @test
     * @throws PropertyNotAccessibleException
     */
    public function should_merge_with_another_array()
    {
        $arrayCollection = $this->createArrayCollection([
            'x' => 11,
            'y' => 22,
            'nested' => [
                'x' => 5,
                'y' => 111,
            ],
        ]);

        $arrayCollection->merge([
            'x' => 89,
            'nested' => [
                'y' => 2,
            ],
        ]);

        $this->assertSame(89, $arrayCollection->get('x'));
        $this->assertSame(22, $arrayCollection->get('y'));
        $this->assertSame(2, $arrayCollection->get('nested.y'));
        $this->assertSame(5, $arrayCollection->get('nested.x'));
    }

    /**
     * @test
     */
    public function should_replace_current_array_with_new_array()
    {
        $array = [
            '6' => 59,
            'he' => 'me',
        ];

        $replaceArray = [
            'v' => 1,
            'b' => 24,
            'z' => [5, 6, 77],
        ];

        $arrayCollection = $this->createArrayCollection($array);
        $this->assertSame($array, $arrayCollection->all());

        $arrayCollection->replace($replaceArray);
        $this->assertSame($replaceArray, $arrayCollection->all());
    }

    /**
     * @test
     * @throws PropertyNotAccessibleException
     */
    public function should_remove_array_key()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $arrayCollection->removeKey('key1');
        $this->assertTrue($arrayCollection->keyDoesNotExists('key1'));

        $arrayCollection->removeKey('key2.x.p2');
        $this->assertFalse($arrayCollection->get('key2.x.p2', false));
    }

    /**
     * @test
     */
    public function should_remove_array_element()
    {
        $array = $this->getTestArray();
        $arrayCollection = $this->createArrayCollection($array);

        $result = $arrayCollection->removeValue('x');
        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
        $this->assertSame($array, $arrayCollection->all());

        $result = $arrayCollection->removeValue(1);
        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result);

        $this->assertFalse(array_multiple_keys_exists($arrayCollection->all(), \array_keys($result)));
    }

    /**
     * @test
     */
    public function should_add_given_array()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $arrayCollection->add([
            'p1' => 11,
            'p2' => 24,
            'pn' => [
                'b1' => 11,
            ],
        ]);

        $this->assertTrue($arrayCollection->keyExists('p1'));
        $this->assertTrue($arrayCollection->keyExists('pn.b1'));
    }

    /**
     * @test
     */
    public function should_clear_array()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());
        $this->assertFalse($arrayCollection->isEmpty());
        $arrayCollection->clear();
        $this->assertTrue($arrayCollection->isEmpty());
    }

    /**
     * @test
     */
    public function should_return_array_collection_as_string()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertContains('#', $arrayCollection->__toString());
    }

    /**
     * @test
     */
    public function should_return_array_cellection_hash()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertSame(
            'd9947bc8febb07f84b611a6218ba8c1f',
            $arrayCollection->getHash()
        );
    }

    /**
     * @test
     */
    public function should_return_array_collection_spl_hash()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());
        $this->assertInternalType('string', $arrayCollection->getSplHash());
    }

    /**
     * @test
     */
    public function should_foreach_collection_as_normal_array()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        foreach ($arrayCollection as $key => $value) {
            $this->assertSame($arrayCollection[$key], $value);
        }
    }

    /**
     * @test
     */
    public function should_have_array_access()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertSame(1, $arrayCollection['key1']);
        $this->assertSame(11, $arrayCollection['key2.z.v']);
        $this->assertNull($arrayCollection['']);
    }

    /**
     * @test
     */
    public function should_check_if_offset_exists()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertTrue(isset($arrayCollection['key1']));
        $this->assertTrue(isset($arrayCollection['key2.x.p2']));
        $this->assertFalse(isset($arrayCollection['noKey']));
        $this->assertFalse(isset($arrayCollection['']));
    }

    /**
     * @test
     * @throws PropertyNotAccessibleException
     */
    public function should_make_offset_set()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertFalse($arrayCollection->keyExists('key11'));
        $arrayCollection['key11'] = 1;
        $this->assertSame(1, $arrayCollection->get('key11'));

        $this->assertFalse($arrayCollection->keyExists('k.b.n'));
        $arrayCollection['k.b.n'] = 'works';
        $this->assertSame('works', $arrayCollection->get('k.b.n'));
    }

    /**
     * @test
     */
    public function should_maked_offset_unset()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertTrue($arrayCollection->keyExists('key1'));
        unset($arrayCollection['key1']);
        $this->assertFalse($arrayCollection->keyExists('key1'));

        $this->assertTrue($arrayCollection->keyExists('key2.x.p1'));
        unset($arrayCollection['key2.x.p1']);
        $this->assertFalse($arrayCollection->keyExists('key2.x.p1'));
    }

    /**
     * @test
     */
    public function should_return_array_count()
    {
        $arrayCollection = $this->createArrayCollection();
        $this->assertEquals(0, $arrayCollection->count());

        $arrayCollection->add(['x' => 11]);
        $this->assertEquals(1, $arrayCollection->count());

        $arrayCollection->add(['x' => 22, 'y' => 23]);
        $this->assertEquals(2, $arrayCollection->count());
    }

    /**
     * @test
     */
    public function should_return_sliced_array()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray([
            'key7' => '11',
            'key8' => 'bla',
            'test',
            'one',
            'two',
        ]));

        $this->assertSame([], $arrayCollection->slice(25, 10));
        $this->assertSame(
            [
                'key3' => 1,
                'key6' => 1,
                'key7' => '11',
                'key8' => 'bla',
            ],
            $arrayCollection->slice(2, 4)
        );
        $this->assertSame($arrayCollection->all(), $arrayCollection->slice(0, 100));
        $this->assertSame(['key1' => 1], $arrayCollection->slice(0, -8));
    }

    /**
     * @test
     */
    public function should_filter_array()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray([
            'love' => 1,
            'hate' => 1,
        ]));

        $this->assertSame(
            [
                'key1' => 1,
                'key3' => 1,
                'key6' => 1,
            ],
            $arrayCollection->filter(
                function ($value, $key) {
                    return $value === 1 && false !== strpos($key, 'key');
                }
            )
        );
    }

    /**
     * @test
     */
    public function should_map_values()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $result = $arrayCollection->map(function ($value) {
            return \is_int($value) ? $value * 25 : $value;
        });

        $this->assertEquals(25, $result['key1']);
    }

    /**
     * @test
     */
    public function should_check_if_element_exists()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());
        $this->assertTrue($arrayCollection->valueExists(1));
        $this->assertTrue($arrayCollection->valueExists(22));
        $this->assertTrue($arrayCollection->valueExists(11));
        $this->assertFalse($arrayCollection->valueExists(9));
    }

    /**
     * @test
     */
    public function should_return_existence_of_key_or_value()
    {
        $arrayCollection = $this->createArrayCollection($this->getTestArray());

        $this->assertFalse($arrayCollection->keyOrValueExists('test1'));
        $this->assertTrue($arrayCollection->keyOrValueExists('key2'));
        $this->assertTrue($arrayCollection->keyOrValueExists(22));
        $this->assertTrue($arrayCollection->keyOrValueExists('key2.z'));
        $this->assertFalse($arrayCollection->keyOrValueExists('key2.b'));
    }

    /**
     * @test
     */
    public function should_construct_immutable_array_collection(): void
    {
        $immutableArrayCollection = new ImmutableArrayCollection(['no' => 'change']);

        $this->assertSame(
            [
                'no' => 'change',
            ],
            $immutableArrayCollection->all()
        );
    }

    /**
     * @test
     */
    public function should_create_immutable_array_collection(): void
    {
        $immutableArrayCollection = (new ImmutableArrayCollection())->create(['no' => 'change']);

        $this->assertSame(
            [
                'no' => 'change',
            ],
            $immutableArrayCollection->all()
        );
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_set_immutable_array_collection(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->set('test', 12);
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_add_immutable_array_collection(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->add(['g' => 'b']);
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_merge_immutable_array_collection(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->merge(['test' => 'b']);
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_replace_immutable_array_collection(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->replace(['test' => 'ccc']);
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_clear_immutable_array_collection(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->clear();
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_remove_key_from_immutable_array_collection(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->removeKey('test');
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_remove_element_from_immutable_array_collection(
    ): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->removeValue(11);
    }

    /**
     * @test
     */
    public function should_create_immutable_array(): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $array = ['test' => 'test'];
        $arrayCollection = new ArrayCollection($array);
        $immutableArrayCollection = (new ImmutableArrayCollection())->create($arrayCollection->all());

        $this->assertSame($array, $immutableArrayCollection->all());
        $immutableArrayCollection->set('a', 'b');
    }

    /**
     * @test
     */
    public function should_return_that_array_value_is_not_null()
    {
        $arrayCollection = new ArrayCollection([
            'test' => 1,
            't2' => [
                'b' => 11,
                'c' => [
                    'd' => 135,
                ],
            ],
        ]);

        $this->assertTrue($arrayCollection->valueIsNotNull('test'));
        $this->assertTrue($arrayCollection->valueIsNotNull('t2.b'));
        $this->assertTrue($arrayCollection->valueIsNotNull('t2.c.d'));
    }

    /**
     * @test
     */
    public function should_not_contain_key()
    {
        $arrayCollection = new ArrayCollection([
            'test' => 1,
        ]);

        $this->assertTrue($arrayCollection->keyDoesNotExists('test2'));
    }

    /**
     * @test
     */
    public function should_not_contain_value()
    {
        $arrayCollection = new ArrayCollection([
            'test' => 1,
        ]);

        $this->assertTrue($arrayCollection->valueDoesNotExists('2'));
    }

    /**
     * @test
     */
    public function should_not_contain_key_or_value()
    {
        $arrayCollection = new ArrayCollection([
            'test' => 1,
        ]);

        $this->assertTrue($arrayCollection->keyOrValueDoesNotExists('test2'));
        $this->assertTrue($arrayCollection->keyOrValueDoesNotExists(11));
    }

    /**
     * @test
     */
    public function should_serialize_array(): void
    {
        $arrayCollection = new ArrayCollection([
            'test' => 1,
            'obj' => new SimpleObject(),
        ]);

        $this->assertSame(
            'a:2:{s:4:"test";i:1;s:3:"obj";O:45:"Sauls\Component\Collection\Stubs\SimpleObject":1:{s:9:"property1";s:5:"prop1";}}',
            $arrayCollection->serialize()
        );
    }

    /**
     * @test
     */
    public function should_unserialize_array(): void
    {
        $arrayCollection = new ArrayCollection([
            'key' => 1,
        ]);

        $arrayCollection->unserialize('a:2:{s:4:"test";i:1;s:3:"obj";O:45:"Sauls\Component\Collection\Stubs\SimpleObject":1:{s:9:"property1";s:5:"prop1";}}');

        $this->assertTrue($arrayCollection->keyExists('test'));
        $this->assertTrue($arrayCollection->keyDoesNotExists('key'));
        $this->assertSame('prop1', $arrayCollection->get('obj.property1'));
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_unset_element_from_immutable_array_collection(
    ): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        unset($immutableCollection['test']);
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_array_set_element_from_immutable_array_collection(
    ): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection['test'] = 25;
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_map_elements_from_immutable_array_collection(
    ): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->map(function ($v) {
            return $v * 15;
        });
    }

    /**
     * @test
     */
    public function should_throw_unsupported_operation_when_trying_to_unserialize_elements_from_immutable_array_collection(
    ): void
    {
        $this->expectException(UnsupportedOperationException::class);
        $immutableCollection = new ImmutableArrayCollection([
            'test' => 11,
        ]);

        $immutableCollection->unserialize('a:2:{s:4:"test";i:1;s:3:"obj";O:45:"Sauls\Component\Collection\Stubs\SimpleObject":1:{s:9:"property1";s:5:"prop1";}}');
    }

    /**
     * @test
     */
    public function should_return_flat_array_keys()
    {
        $arrayCollection = new ArrayCollection([
            'a' => 1,
            'b' => 2,
        ]);

        $this->assertSame(
            [
                0 => 'a',
                1 => 'b',
            ],
            $arrayCollection->keys()->all()
        );
    }

    /**
     * @test
     */
    public function should_return_assoc_array_keys()
    {
        $arrayCollection = new ArrayCollection([
            'a' => 1,
            'c' => [
                'd' => 11
            ],
            'g' => 2,
            'x' => [
                'y' => [
                    'z' => [
                        'yes' => 11
                    ]
                ]
            ]
        ]);

        $this->assertSame(
            [
                0 => 'a',
                1 => 'c.d',
                2 => 'g',
                3 => 'x.y.z.yes',
            ],
            $arrayCollection->keys()->all()
        );
    }
}

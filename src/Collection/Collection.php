<?php declare(strict_types=1);
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Collection;

use Traversable;

class Collection implements CollectionInterface, \Countable
{
    /**
     * @var mixed[]
     */
    protected $values = [];

    /**
     * @param mixed[] $collection
     */
    public function __construct(array $collection = [])
    {
        $this->values = $collection;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return $this->values[$name];
        } else {
            return $this->throwNotFound($name);
        }
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->values);
    }

    public function set(string $name, $object)
    {
        $this->values[$name] = $object;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->values);
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

    public function count(): int
    {
        return count($this->values);
    }

    /**
     * @return mixed[]
     */
    public function select(callable $callback): array
    {
        $values = [];

        foreach ($this as $key => $value) {
            if ($callback($value, $key)) {
                $values[$key] = $value;
            }
        }

        return $values;
    }

    /**
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function first()
    {
        if ($this->count() === 0) {
            throw new \InvalidArgumentException("no elements found in collection.");
        }

        return array_values($this->values)[0];
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return iterator_to_array($this);
    }

    protected function throwNotFound(string $name)
    {
        throw new \InvalidArgumentException("`$name` not found in collection.");
    }
}

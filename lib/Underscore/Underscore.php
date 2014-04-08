<?php

namespace Underscore;

use Underscore\Initializer\FromInitializer;

/**
 * Class Underscore
 * @package Underscore
 *
 * @method static Underscore from($item)
 * @method static Underscore range(int $start, int $stop, int $step = 1)
 *
 * @method Underscore invoke(callable $iterator)
 * @method Underscore reduce(callable $iterator, mixed $initial = null)
 * @method Underscore reduceRight(callable $iterator, mixed $initial = null)
 * @method Underscore map(callable $iterator)
 * @method Underscore pick(mixed $key)
 * @method Underscore all(callable $iterator)
 * @method Underscore any(callable $iterator)
 * @method Underscore filter(callable $iterator)
 * @method Underscore reject(callable $iterator)
 * @method Underscore find(callable $iterator)
 * @method Underscore groupBy(callable $iterator)
 * @method Underscore sortBy(callable $iterator)
 * @method Underscore tap(callable $iterator)
 * @method Underscore contains(mixed $needle)
 * @method Underscore compact()
 * @method Underscore values()
 * @method Underscore keys()
 * @method Underscore flatten()
 * @method Underscore head(int $count = 1)
 * @method Underscore tail(int $count = 1)
 * @method Underscore initial(int $count = 1)
 * @method Underscore last(int $count = 1)
 * @method Underscore zip(array $keys)
 * @method Underscore merge($values)
 * @method Underscore without($values)
 */
class Underscore
{
    /** @var  Collection */
    protected $wrapped;

    /**
     * @param Collection $wrapped
     */
    public function __construct(Collection $wrapped = null)
    {
        $this->wrapped = $wrapped;
    }

    /**
     * Returns object
     *
     * @return mixed
     */
    public function value()
    {
        return $this->wrapped->value();
    }

    /**
     * Returns object as array
     *
     * @return mixed[]
     */
    public function toArray()
    {
        return $this->wrapped->toArray();
    }

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public function __call($method, $args)
    {
        $payloadClass = sprintf('\Underscore\Mutator\%sMutator', ucfirst($method));
        /** @var $payload callable */
        $payload = new $payloadClass();

        array_unshift($args, $this->wrapped);
        $this->wrapped = call_user_func_array($payload, $args);

        return $this;
    }

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public static function __callStatic($method, $args)
    {
        $payloadClass = sprintf('\Underscore\Initializer\%sInitializer', ucfirst($method));
        /** @var $payload callable */
        $payload = new $payloadClass();

        return call_user_func_array($payload, $args);
    }

    /**
     * Gets the size of the collection by returning length for arrays or number of enumerable properties for objects.
     *
     * Returns int
     *
     * @return Underscore
     */
    public function size()
    {
        return $this->wrapped->count();
    }

    /**
     * Clones makes clone of collection
     *
     * @return Underscore
     */
    public function clon()
    {
        /** @noinspection PhpParamsInspection */
        return call_user_func(new FromInitializer(), unserialize(serialize($this->wrapped->value())));
    }
}

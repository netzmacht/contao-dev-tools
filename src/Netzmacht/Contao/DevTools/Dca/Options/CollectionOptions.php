<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DevTools\Dca\Options;

use Model\Collection;

/**
 * Class CollectionOptions maps a model collection to the option format.
 *
 * @package Netzmacht\Contao\DevTools\Dca\Options
 */
class CollectionOptions implements Options
{
    /**
     * The database result.
     *
     * @var mixed
     */
    protected $collection;

    /**
     * The label column.
     *
     * @var string
     */
    private $labelColumn;

    /**
     * The value column.
     *
     * @var string
     */
    private $valueColumn = 'id';

    /**
     * Instead of a label column you can define a callable.
     *
     * @var \callable
     */
    private $labelCallback;

    /**
     * Current position.
     *
     * @var int
     */
    private $position = 0;

    /**
     * Construct.
     *
     * @param Collection $collection  Model collection.
     * @param string     $labelColumn Name of label column.
     * @param string     $valueColumn Name of value column.
     */
    public function __construct($collection, $labelColumn = null, $valueColumn = 'id')
    {
        $this->collection  = $collection;
        $this->labelColumn = $labelColumn;
        $this->valueColumn = $valueColumn;
    }

    /**
     * Get the label column.
     *
     * @return string
     */
    public function getLabelColumn()
    {
        return $this->labelColumn;
    }

    /**
     * Set label column.
     *
     * @param string $labelColumn Label column.
     *
     * @return $this
     */
    public function setLabelColumn($labelColumn)
    {
        $this->labelColumn = $labelColumn;

        return $this;
    }

    /**
     * Get the value column.
     *
     * @return string
     */
    public function getValueColumn()
    {
        return $this->valueColumn;
    }

    /**
     * Set the value column.
     *
     * @param string $valueColumn Value column.
     *
     * @return $this
     */
    public function setValueColumn($valueColumn)
    {
        $this->valueColumn = $valueColumn;

        return $this;
    }

    /**
     * Set the label callback.
     *
     * If a label callback is defined it is used no matter if any label column is selection. The callback gets the
     * current Model as argument.
     *
     * @param callable $labelCallback Label callback.
     *
     * @return $this
     */
    public function setLabelCallback($labelCallback)
    {
        $this->labelCallback = $labelCallback;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if ($this->labelCallback) {
            return call_user_func($this->labelCallback, $this->collection->row());
        }

        return $this->collection->{$this->labelColumn};
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->position++;
        $this->collection->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->collection->{$this->valueColumn};
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->position < $this->collection->count();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
        $this->collection->reset();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        foreach ($this->collection as $row) {
            if ($row->{$this->valueColumn} === $offset) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        foreach ($this->collection as $row) {
            if ($row->{$this->valueColumn} === $offset) {
                return $row->row();
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        // unsupported
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        // unsupported
    }

    /**
     * {@inheritdoc}
     */
    public function getArrayCopy()
    {
        $values = array();

        foreach ($this as $id => $value) {
            $values[$id] = $value;
        }

        return $values;
    }
}

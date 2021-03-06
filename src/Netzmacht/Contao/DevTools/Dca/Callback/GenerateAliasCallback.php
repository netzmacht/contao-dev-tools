<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\DevTools\Dca\Callback;


use Netzmacht\Contao\DevTools\Data\AliasGenerator;

class GenerateAliasCallback
{
    /**
     * The alias generator.
     *
     * @var AliasGenerator
     */
    private $generator;

    /**
     * Construct.
     *
     * @param AliasGenerator $generator The alias generator.
     */
    public function __construct(AliasGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Get the alias generator.
     *
     * @return AliasGenerator
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Generate the alias value.
     *
     * @param mixed          $value         The current value.
     * @param \DataContainer $dataContainer The data container driver.
     *
     * @return mixed|null|string
     */
    public function __invoke($value, $dataContainer)
    {
        return $this->generator->generate($dataContainer->activeRecord, $value);
    }
}

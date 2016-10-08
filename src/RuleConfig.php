<?php
/*
 * This file is part of Bounce-Detection.
 *
 * (c)2016 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cwd\BounceDetection;

/**
 * Class RuleConfig
 *
 * @package Cwd\BounceDetection
 * @author  Ludwig Ruderstaller <l.ruderstaller@cwd.at>
 */
class RuleConfig implements \IteratorAggregate
{
    /**
     * @var array
     */
    protected $rules;

    /**
     * RuleConfig constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return mixed|null
     */
    public function getBodyRules()
    {
        return (isset($this->rules['body'])) ? $this->rules['body'] : null;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->rules);
    }
}

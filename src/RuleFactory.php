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

use Symfony\Component\Yaml\Yaml;

/**
 * Class RuleFactory
 *
 * @package Cwd\BounceDetection
 * @author  Ludwig Ruderstaller <l.ruderstaller@cwd.at>
 */
class RuleFactory
{
    const RULE_FILE = 'rules.yml';

    /**
     * @param null|string $ruleFile
     *
     * @return RuleConfig
     * @throws \Exception
     */
    public static function getRules($ruleFile = null)
    {
        if ($ruleFile === null) {
            $ruleFile = __DIR__.'/'.self::RULE_FILE;
        }

        if (!file_exists($ruleFile) || !is_readable($ruleFile)) {
            throw new \Exception(sprintf('Rule file %s is not found or not readable', $ruleFile));
        }

        $rules = Yaml::parse(file_get_contents($ruleFile));

        return new RuleConfig($rules);
    }
}

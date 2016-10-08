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
 * Class Detector
 *
 * @package Cwd\BounceDetection
 * @author  Ludwig Ruderstaller <l.ruderstaller@cwd.at>
 */
class Detector
{
    /**
     * @var RuleConfig|null
     */
    protected $ruleConfig = null;

    public function __construct($ruleFile = null)
    {
        $this->ruleConfig = RuleFactory::getRules($ruleFile);
    }

    /**
     * @param string $mail
     *
     * @return array
     */
    public function testAll($mail)
    {
        $result = $this->testRulesAgainst($this->ruleConfig->getBodyRules(), $mail);

        return $result;
    }

    public function testRulesAgainst(array $rules, $mail)
    {
        foreach ($rules as $rule) {
            if (preg_match($rule['regexp'], $mail, $match)) {
                return [
                    'rule_cat' => $rule['category'],
                    'rule_no'  => $rule['number'],
                ];
            }
        }
    }
}

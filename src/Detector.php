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
use PhpMimeMailParser\Parser;

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
        $result = $this->testRulesAgainst($this->ruleConfig->getDSNRules(), $mail);

        if ($result === null) {
            $result = $this->testRulesAgainst($this->ruleConfig->getBodyRules(), $mail);
        }

        if ($result === null) {

        }

        $result['email'] = $this->findEmail($mail);

        return $result;
    }

    /**
     * @param $mail
     *
     * @return string
     */
    public function findEmail($mail)
    {
        foreach ($this->ruleConfig->getEmailRules() as $rule) {
            if (preg_match($rule['regexp'], $mail, $match)) {
                return $match[1];
            }
        }

        return null;
    }

    /**
     * @param array  $rules
     * @param string $mail
     *
     * @return array
     */
    public function testRulesAgainst(array $rules, $mail)
    {
        $parser = new Parser();
        $parser->setText($mail);
        $data = $parser->getData();

        foreach ($rules as $rule) {
            if (preg_match($rule['regexp'], $data, $match)) {
                $result = [
                    'rule_cat' => $rule['category'],
                    'rule_no'  => $rule['number'],
                ];

                if (isset($rule['idx_email'])) {
                    $result['email'] = $match[$rule['idx_email']];
                }

                return $result;
            }
        }
    }
}

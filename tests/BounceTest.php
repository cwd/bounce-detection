<?php
/*
 * This file is part of MailingOwl.
 *
 * (c)2016 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cwd\BounceDetection\Tests;

use Cwd\BounceDetection\Detector;

/**
 * Class BounceTest
 *
 * Testcases are under heavy development!
 *
 * @package Cwd\BounceDetection\Tests
 * @author  Ludwig Ruderstaller <l.ruderstaller@cwd.at>
 */
class BounceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Detector
     */
    protected static $detector;

    /**
     * Setup
     */
    public static function setUpBeforeClass()
    {
        self::$detector = new Detector();
    }

    public function testNoFound()
    {
        $mail = file_get_contents('tests/fixtures/PHP-Bounce-Handler/1.eml');

        $result = self::$detector->testAll($mail);

        $this->assertArrayHasKey('rule_no', $result);
        $this->assertEquals($result['rule_no'], '0157');
        $this->assertEquals($result['rule_cat'], 'unknown');
    }
}

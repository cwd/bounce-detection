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

    /**
     *
     * @return array
     */
    public static function mailDataProvider()
    {
        return self::readFixtures('tests/fixtures');
    }

    /**
     * @param string $fileName
     * @dataProvider mailDataProvider
     */
    public function testMail($fileName)
    {
        $mail = file_get_contents($fileName);

        $result = self::$detector->testAll($mail);

        /*
        if ($result === null) {
            dump([$fileName => '-- Nothing found --']);
        } else {
            dump([$fileName => $result]);
        }
         */

        $this->assertEquals(true, is_array($result));

    }

    /**
     * @param string $directory
     *
     * @return array
     */
    protected static function readFixtures($directory)
    {
        $fixtures = [];

        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        foreach($objects as $name => $object) {
            $filename = $object->getFilename();
            if ($filename === '.' || $filename === '..' || $filename === 'README') {
                continue;
            }

            $fixtures[] = [$name];
        }

        return $fixtures;
    }
}

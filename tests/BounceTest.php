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

    protected $falsePositiv = [
        'tests/fixtures/bounce-email/tt_1234210666.txt',
        'tests/fixtures/bounce-email/tt_1234211024.txt',
        'tests/fixtures/bouncehammer/cannot-parse.eml',
        'tests/fixtures/tmail_bouncer/legit_multipart.eml',
        'tests/fixtures/tmail_bouncer/yahoo_legit.eml',
        'tests/fixtures/tmail_bouncer/out_of_office.eml',
        'tests/fixtures/PHP-Bounce-Handler/46.eml',
        'tests/fixtures/PHP-Bounce-Handler/29.eml',
        'tests/fixtures/mail-deliverystatus-bounceparser/spam-with-image.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/aol-senderblock.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/polish-autoreply.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/spam-lots-of-bogus-addresses.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/aol-vacation.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/spam-with-badly-parsed-email.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/bluebottle.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/no-message-collected.msg',
        'tests/fixtures/mail-deliverystatus-bounceparser/autoreply.msg',
        'tests/fixtures/node-baunsu/encoded_spam.txt',
    ];

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

        if (!in_array($fileName, $this->falsePositiv)) {
            $this->assertEquals(3, count($result));
        }
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

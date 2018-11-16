<?php
/*
 * This file is part of the php-code-coverage package.
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class SampleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \SampleTest::testAssertEquals()
     */
    public function testAssertEquals(): void
    {
        $this->assertEquals('foo', 'foo');
    }

    /**
     * @covers \SampleTest::testAssertSame()
     */
    public function testAssertSame(): void
    {
        $this->assertSame('first', 'first');
    }

    /**
     * @covers \SampleTest::testAssertTrue()
     */
    public function testAssertTrue(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers \SampleTest::testAssertFalse()
     */
    public function testAssertFalse(): void
    {
        $this->assertFalse(false);
    }
}

<?php
class SampleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \SampleTest::testAssertEquals()
     */
    public function testAssertEquals()
    {
        $this->assertEquals('foo', 'foo');
    }

    /**
     * @covers \SampleTest::testAssertSame()
     */
    public function testAssertSame()
    {
        $this->assertSame('first', 'first');
    }
	
    /**
     * @covers \SampleTest::testAssertTrue()
     */
    public function testAssertTrue()
    {
        $this->assertTrue(true);
    }

    /**
     * @covers \SampleTest::testAssertFalse()
     */
    public function testAssertFalse()
    {
        $this->assertFalse(false);
    }

}

<?php
class SampleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers testAssertEquals
     */
    public function testAssertEquals()
    {
        $this->assertEquals('foo', 'foo');
    }

    /**
     * @covers testAssertSame
     */
    public function testAssertSame()
    {
        $this->assertSame('first', 'first');
    }
	
    /**
     * @covers testAssertTrue
     */
    public function testAssertTrue()
    {
        $this->assertTrue(true);
    }

    /**
     * @covers testAssertFalse
     */
    public function testAssertFalse()
    {
        $this->assertFalse(false);
    }

}

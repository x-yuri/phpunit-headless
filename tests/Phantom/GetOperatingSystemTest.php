<?php
class GetOperatingSystemTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOperatingSystem()
    {
        $result = GetOperatingSystem::getOS();

        // e.g. Windows_NT_5.1
        $expected = str_replace(' ' , '_', php_uname('s') . ' ' . php_uname('r'));

        $this->assertEquals($result, $expected);
    }

    /**
     * @codeCoverageIgnore
     */
    public function testGetWindowsVersion()
    {
        $result = GetOperatingSystem::GetWindowsVersion();

        // it's either the proper name for a windows NT version or a bypass
        if ($result != php_uname('r')) {
            $expect = array('XP', 'XP Pro 64', '7', '8');
            $this->assertTrue(in_array($result, $expect));
        } else {
            $this->assertEquals($result, php_uname('r'));
        }
    }

    public function testGetMachine()
    {
        $this->assertEquals(php_uname('m'), GetOperatingSystem::getMachine());
    }

    /**
     * @codeCoverageIgnore
     */
    public function testGetBitSize()
    {
        $result = GetOperatingSystem::getBitSize();

        if (PHP_INT_SIZE === 4) {
            $this->assertTrue($result == 32);
        } elseif (PHP_INT_SIZE === 8) {
            $this->assertTrue($result == 64);
        } else {
            $this->assertEquals(PHP_INT_SIZE, GetOperatingSystem::getBitSize());
        }
    }

    public function testToString()
    {
        $expectedString = sprintf(
            'OS %s %s (%s-bit)',
            GetOperatingSystem::getOS(),
            GetOperatingSystem::getMachine(),
            GetOperatingSystem::getBitSize()
        );

        $os = new GetOperatingSystem();
        $result = $os->__toString();

        $this->assertTrue(is_string($result));
        $this->assertEquals($expectedString, $result);
    }
}

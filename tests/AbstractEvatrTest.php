<?php

namespace Codedge\Evatr\Tests;

use Codedge\Evatr\AbstractEvatr;
use Orchestra\Testbench\TestCase;

/**
 * AbstractEvatrTest.
 *
 * @author Holger Lösken <holger.loesken@codedge.de>
 * @copyright See LICENSE file that was distributed with this source code.
 */
class AbstractEvatrTest extends TestCase
{
    public function testGetPrintConfirmationOption()
    {
        /** @var AbstractEvatr $mock */
        $mock = $this->getMockForAbstractClass('Codedge\Evatr\AbstractEvatr');

        $this->assertSame(true, $mock->_getPrintConfirmationOption('ja'));
        $this->assertSame(false, $mock->_getPrintConfirmationOption('nein'));
    }

    public function testSetPrintConfirmationOption()
    {
        /** @var AbstractEvatr $mock */
        $mock = $this->getMockForAbstractClass('Codedge\Evatr\AbstractEvatr');

        $this->assertSame('ja', $mock->_setPrintConfirmationOption(true));
        $this->assertSame('nein', $mock->_setPrintConfirmationOption(false));
    }
}

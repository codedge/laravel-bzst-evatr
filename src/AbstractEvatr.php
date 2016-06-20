<?php

namespace Codedge\Evatr;

/**
 * Abstract class for Evatr
 *
 * @author Holger Lösken <holger.loesken@codedge.de>
 * @copyright See LICENSE file that was distributed with this source code.
 *
 */
abstract class AbstractEvatr
{
    const OPT_TRUE = 'ja';
    const OPT_FALSE = 'nein';

    /**
     * Returns the "translated" and converted valued for a confirmation/official confirmation.
     *
     * @param string $option
     *
     * @return bool
     */
    public function _getPrintConfirmationOption($option)
    {
        return $option === self::OPT_TRUE ? true : false;
    }

    /**
     * Set the print confirmation option. Translates booleans to strings
     *
     * @param bool $option
     *
     * @return string
     */
    public function _setPrintConfirmationOption($option)
    {
        return $option ? self::OPT_TRUE : self::OPT_FALSE;
    }
}
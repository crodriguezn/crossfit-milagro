<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   ZendX
 * @package    ZendX_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: StaticTest.php 4700 2007-05-04 04:25:11Z bkarwin $
 */


/**
 * @see Zend_Db_Profiler_TestCommon
 */
require_once 'Zend/Db/Profiler/TestCommon.php';


PHPUnit_Util_Filter::addFileToFilter(__FILE__);


/**
 * @category   Zend
 * @package    Zend_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class ZendX_Db_Profiler_FirebirdTest extends Zend_Db_Profiler_TestCommon
{

    protected function _testProfilerSetFilterQueryTypeCommon($queryType)
    {
        $bugs = $this->_db->quoteIdentifier('zfbugs', true);
        $bug_status = $this->_db->quoteIdentifier('bug_status', true);
        $bug_id = $this->_db->quoteIdentifier('bug_id', true);

        $prof = $this->_db->getProfiler();
        $prof->setEnabled(true);

        $this->assertSame($prof->setFilterQueryType($queryType), $prof);
        $this->assertEquals($queryType, $prof->getFilterQueryType());

        $this->_db->query("SELECT * FROM $bugs");
        $this->_db->query("INSERT INTO $bugs ($bug_id, $bug_status) VALUES (GEN_ID(\"zfbugs_seq\", 1), ?)", array('NEW'));
        $this->_db->query("DELETE FROM $bugs");
        $this->_db->query("UPDATE $bugs SET $bug_status = ?", array('FIXED'));

        $qps = $prof->getQueryProfiles();
        $this->assertTrue(is_array($qps), 'Expecting some query profiles, got none');
        foreach ($qps as $qp) {
            $qtype = $qp->getQueryType();
            $this->assertEquals($queryType, $qtype,
                "Found query type $qtype, which should have been filtered out");
        }

        $prof->setEnabled(false);
    }

    public function getDriver()
    {
        return 'Firebird';
    }
}

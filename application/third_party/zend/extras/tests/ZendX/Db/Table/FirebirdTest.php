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
 */

require_once 'Zend/Db/Table/TestCommon.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__);

class ZendX_Db_Table_FirebirdTest extends Zend_Db_Table_TestCommon
{

    public function testTableInsert()
    {
        $this->markTestSkipped($this->getDriver().' does not support auto-increment columns.');
    }
	
    public function testTableInsertWithSchema()
    {
        $this->markTestSkipped($this->getDriver() . ' does not report its schema as we expect.');	
	}
	
    public function testTableCascadeDelete()
    {
        $table = $this->_table['products'];
        $row1 = $table->find(2)->current();
        $row1->delete();

        // Test for 'false' value in cascade config
        $table = $this->_table['bugs'];
        $row2 = $table->find(1)->current();
        $row2->delete();

        $table = $this->_table['bugs_products'];
        $select = $table->select()
            ->where('"product_id" = ?', 2);

        $rows = $table->fetchAll($select);
        $this->assertEquals(0, count($rows));
    }	

    public function getDriver()
    {
        return 'Firebird';
    }

}

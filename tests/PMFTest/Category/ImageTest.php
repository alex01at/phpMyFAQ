<?php

/**
 * The category image test class.
 *
 * PHP Version 5.6
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2016 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2016-09-08
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    exit();
}

/**
 * Test category images.
 *
 * @category  phpMyFAQ
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2016 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2016-09-08
 */
class PMFTest_Category_ImageTest extends PHPUnit_Framework_TestCase
{

    /** @var PMF_Category_Image */
    private $instance;

    protected function setUp()
    {
        $dbHandle  = new PMF_DB_Sqlite3();
        $dbHandle->connect(PMF_TEST_DIR.'/test.db', '', '');
        $pmfConfig = new PMF_Configuration($dbHandle);
        $pmfConfig->set('records.maxAttachmentSize', 1234567890);
        $this->instance = new PMF_Category_Image($pmfConfig);
    }

    public function testNoUploadGetFileName()
    {
        $categoryId = 1;
        $categoryName = 'de';
        $uploadedFile = [
            'name' => '',
            'type' => '',
            'tmp_name' => '',
            'error' => 4,
            'size' => 0
        ];

        $this->instance->setUploadedFile($uploadedFile);

        $this->assertEquals('', $this->instance->getFileName($categoryId, $categoryName));
    }

    public function testUploadedGetFileName()
    {
        $categoryId = 1;
        $categoryName = 'de';
        $uploadedFile = [
            'name' => 'Foobar.png',
            'type' => 'image/png',
            'tmp_name' => '/private/var/tmp/phpSgODqb',
            'error' => 0,
            'size' => 1336915
        ];

        $this->instance->setUploadedFile($uploadedFile);
        
        $this->assertEquals('category-1-de.png', $this->instance->getFileName($categoryId, $categoryName));
    }
}

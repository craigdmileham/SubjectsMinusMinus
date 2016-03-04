<?php
include "../../lib/SubjectsPlus/Control/FAQ.php";
class FAQTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
	
    protected function _before()
    {
		$this->tester = new FAQ();
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
		 
		 $this->tester->_faq_id = 1;
		 $this->tester->assertEquals(1, $faq->getRecordId());
		 
    }
}
?>
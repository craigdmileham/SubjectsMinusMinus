<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the index page displays the expected output');
$I->amOnPage('localhost:81/subjects/index.php');
$I->see('Quick Search');
$I->click('Go');
//$I->
?>
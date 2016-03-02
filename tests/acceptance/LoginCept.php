<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Make sure login works');
$I->amOnPage('/control/login.php'); 
$I->fillField('username', 'jheise@drew.edu');
$I->fillField('password', 'w3bm@n@g3r');
$I->click('Submit');
$I->see('SubjectsPlus', 'title');


?>
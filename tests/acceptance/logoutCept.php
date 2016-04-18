
<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('verify logout functionality works');
$I->amOnPage('/control/login.php');
$I->see('Please enter your credentials to proceed');
$I->fillField('Email', 'jheise@drew.edu');
$I->fillField('Password', 'w3bm@n@g3r');
$I->click('Submit');
$I->see('Hello Jenne Heise');
$I->click('Log Out');
$I->see('Please enter your credentials to proceed');
?>
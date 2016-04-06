
<?php
//barebones test of featured resource
$I = new AcceptanceTester($scenario);
$I->wantTo('make sure that featured resource is visible');
$I->amOnPage('/subjects/index.php');
$I->see("Featured Resource");
$I->amOnPage('/control/login.php');
$I->see('Please enter your credentials to proceed');
$I->fillField('Email', 'jheise@drew.edu');
$I->fillField('Password', 'w3bm@n@g3r');
$I->click('Submit');
//changed course to featured
$I->click('Browse Items');
$I->click('Avalon Project');
$I->seeInCurrentUrl("control/records/record.php?record_id=261");
$I->checkOption('featured');
$I->click("Save Record Now");
//check if it is featured
$I->amOnPage('/subjects/index.php');
$I->see("Avalon Project");

//undo above
$I->amOnPage('/control/login.php');
$I->see('Please enter your credentials to proceed');
$I->fillField('Email', 'jheise@drew.edu');
$I->fillField('Password', 'w3bm@n@g3r');
$I->click('Submit');
$I->click('Browse Items');
$I->click('Avalon Project');
$I->seeInCurrentUrl("control/records/record.php?record_id=261");
$I->seeCheckboxIsChecked('featured');
$I->checkOption('featured');
$I->click("Save Record Now");
//make sure it is gone
$I->amOnPage('/subjects/index.php');
$I->dontSee("Avalon Project");
?>
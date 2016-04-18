<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Test Guide Search on main page');
$I->amOnPage('subjects/index.php'); 
$I->fillField('searchterm', 'art');
$I->click('Go');
$I->seeInCurrentUrl('subjects/search.php');
$I->see('Art History');
?>

<?php
//barebones test of featured resource
$I = new AcceptanceTester($scenario);
$I->wantTo('make sure that featured resource is visible');
$I->amOnPage('/subjects/index.php');
$I->see("Featured Resource");

?>
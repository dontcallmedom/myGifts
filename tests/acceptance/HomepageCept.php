<?php
$I = new AcceptanceTester\AdminSteps($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/');
$I->login();
$I->amOnPage('/index.php');
$I->see('My List');
$I->see('administration');
$I->logout();
?>
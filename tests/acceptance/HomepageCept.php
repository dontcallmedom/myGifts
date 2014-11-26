<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/');
$I->see('Login');
$I->fillField('name', 'tester');
$I->fillField('password', 'tester');
$I->click('login');
$I->amOnPage('/index.php');
$I->see('My List');
?>
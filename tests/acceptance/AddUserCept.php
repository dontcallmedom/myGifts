<?php
$I = new AcceptanceTester\AdminSteps($scenario);
$I->amOnPage('/');
$I->login();
$I->click('administration');
$I->seeInCurrentUrl('adminUsers');
$I->see("tester");
$I->click('add');
$I->seeInCurrentUrl('adminEditUser');
$I->see("User administration");
$I->fillField('name', 'user');
$I->fillField('email', 'user@localhost.net');
$I->fillField('birthDate[Date_Month]', '02');
$I->fillField('birthDate[Date_Day]', '29');
$I->fillField('password', 'user');
$I->click('add');
$I->logout();

$they = new AcceptanceTester\NormalUserSteps($scenario);
$they->login();
$they->see("My List");
$they->logout();
?>
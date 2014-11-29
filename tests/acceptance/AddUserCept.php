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
$I->fillField('name', 'foo');
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

$I->login();
$I->addNormalUser();
$I->see('error');
$I->see('already exists');

$I->amOnPage('/?handler=adminUsers');
$I->click(['xpath' => '//a[.="delete"][1]']);
$I->see('delete user foo');
$I->click('Yes');
$I->dontSee('foo');
$I->logout();
?>
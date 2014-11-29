<?php
namespace AcceptanceTester;

class AdminSteps extends \AcceptanceTester
{
    public function login()
    {
        $I = $this;
        $I->see("Login");
        $I->see('Login');
        $I->fillField('name', 'tester');
        $I->fillField('password', 'tester');
        $I->click('login');
    }

    public function logout()
    {
        $I = $this;
        $I->click('logout');
    }

    public function addNormalUser()
    {
        $I = $this;
        $I->amOnPage('/index.php?handler=adminEditUser');
        $I->fillField('name', 'user');
        $I->fillField('email', 'user@localhost.net');
        $I->fillField('birthDate[Date_Month]', '02');
        $I->fillField('birthDate[Date_Day]', '29');
        $I->fillField('password', 'user');
        $I->click('add');
    }
}
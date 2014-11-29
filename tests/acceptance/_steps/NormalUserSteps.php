<?php
namespace AcceptanceTester;

class NormalUserSteps extends \AcceptanceTester
{
    public function login()
    {
        $I = $this;
        $I->see("Login");
        $I->fillField('name', 'foo');
        $I->fillField('password', 'user');
        $I->click('login');

    }
    public function logout()
    {
        $I = $this;
        $I->click('logout');
    }
}
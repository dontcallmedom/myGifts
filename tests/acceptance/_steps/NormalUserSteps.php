<?php
namespace AcceptanceTester;

class NormalUserSteps extends \AcceptanceTester
{
    public function login($password = 'user')
    {
        $I = $this;
        $I->see("Login");
        $I->fillField('name', 'foo');
        $I->fillField('password', $password);
        $I->click('login');

    }
    public function logout()
    {
        $I = $this;
        $I->click('logout');
    }
}
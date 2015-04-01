<?php

require 'PHPUnit/Autoload.php';
require '../models/Account.php';

class AccountTest extends PHPUnit_Framework_TestCase {
    
    /*
     *  @dataProvider providerchekCheckLogin
     */
    public function testchek_login($result, $name) {
        $ob = new Account();
        $this->assertEquals($result,$ob->chek_login($name));
    }
    
    public function  providerchekCheckLogin() {
        return array(
            array(1, 'admin'),
            array(1, 'Han'),
            array(1, 'Name'),
            array(1, 'Noob'),
            array(1, 'admin2')
        );
    }
    
    public function testget_user() {
        $ob = new Account();
        $this->assertEquals(true,$ob->get_user(100));
    }
}

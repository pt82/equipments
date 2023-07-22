<?php


namespace App\Services;


use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ParseService  extends DuskTestCase
{

    public function parse()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://swgoh.gg/accounts/login/');
//                ->click('#id_login')
//                ->type('text', 'kaban92')
//                ->click('#id_password')
//                ->type('text', 'Kmt4675002')
//                ->click('.primaryAction btn btn-primary pull-right')
//                ->pause(500);

//            $btn = $browser->element('.btn .btn-default .pull-left');
        });
//        return $btn;
    }
}

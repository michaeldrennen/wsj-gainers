<?php

namespace MichaelDrennen\WSJGainers\Tests;

use Carbon\Carbon;
use MichaelDrennen\WSJGainers\Bot;
use PHPUnit\Framework\TestCase;

class BotTest extends TestCase {

    /**
     * @test
     * @group valid
     */
    public function getValidPageShouldReturn100Rows() {
        ini_set('memory_limit', -1);
        ini_set('error_reporting', E_ALL);

        $date = Carbon::parse('2018-08-28');
        $bot = new Bot();
        $results = $bot->get($date);
    }
}
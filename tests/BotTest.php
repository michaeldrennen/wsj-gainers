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
        $date    = Carbon::parse( '2018-08-28' );
        $bot     = new Bot();
        $results = $bot->get( $date );

        $this->assertCount( 100, $results );
    }

    /**
     * @test
     * @group invalid
     */
    public function getInvalidPageShouldThrowException() {
        $this->expectException( \Exception::class );
        $date    = Carbon::parse( '2018-08-26' );
        $bot     = new Bot();
        $results = $bot->get( $date );
        print_r( $results );

    }
}
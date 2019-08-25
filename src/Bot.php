<?php

namespace MichaelDrennen\WSJGainers;


use Carbon\Carbon;
use Sunra\PhpSimple\HtmlDomParser;


class Bot {

    // 'http://www.wsj.com/mdc/public/page/2_3021-gaincomp-gainer-20180828.html'
    protected $urlPrefix = 'http://www.wsj.com/mdc/public/page/2_3021-gaincomp-gainer-';
    protected $urlSuffix = '.html';
    protected $url;
    protected $rows      = [];

    public function __construct() {

    }

    /**
     * @param \Carbon\Carbon $date
     * @return array
     * @throws \Exception
     */
    public function get( Carbon $date ) {
        $this->setUrl( $date );
        $content = file_get_contents( $this->url );
        $dom     = HtmlDomParser::str_get_html( $content );

        if(false === $dom):
            throw new \Exception("HtmlDomParser::str_get_html() returned false. Check the URL.");
        endif;

        $trs     = $dom->find( 'table.mdcTable tbody tr' );
        array_shift( $trs ); // Remove the header rows.

        foreach ( $trs as $tr ):
            $tds = $tr->find( 'td' );

            //$rowNumber = $tds[ 0 ]->plaintext; // Not needed
            $name    = $tds[ 1 ]->plaintext;
            $price   = $tds[ 2 ]->plaintext;
            $change  = $tds[ 3 ]->plaintext;
            $percent = $tds[ 4 ]->plaintext;
            $volume  = $tds[ 5 ]->plaintext;

            $ticker = $this->parseOutTicker( $name );

            $this->rows[] = [
                'ticker'  => $ticker,
                'price'   => $price,
                'change'  => $change,
                'percent' => $percent,
                'volume'  => $volume,
            ];
        endforeach;

        if ( 0 == count( $this->rows ) ):
            throw new \Exception( "No results. The date you passed in was probably a weekend or market holiday." );
        endif;

        return $this->rows;
    }

    /**
     * @param \Carbon\Carbon $date
     */
    protected function setUrl( Carbon $date ) {
        $this->url = $this->urlPrefix . $date->format( 'Ymd' ) . $this->urlSuffix;
    }

    /**
     * @param string $name Example: Asta Funding (ASFI)
     * @return string The ticker parsed out of the name field.
     */
    protected function parseOutTicker( string $name ): string {
        preg_match( '/\((.*)\)/', $name, $matches );
        return $matches[ 1 ];
    }


}
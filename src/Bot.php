<?php

namespace MichaelDrennen\WSJGainers;


use Carbon\Carbon;
use Sunra\PhpSimple\HtmlDomParser;


class Bot {

    // 'http://www.wsj.com/mdc/public/page/2_3021-gaincomp-gainer-20180828.html'
    protected $urlPrefix = 'http://www.wsj.com/mdc/public/page/2_3021-gaincomp-gainer-';
    protected $urlSuffix = '.html';
    protected $url;

    public function __construct() {

    }

    public function get( Carbon $date ) {
        $this->setUrl( $date );

        echo "\nabout to load content\n";
        $content = file_get_contents( $this->url );

        //echo $content;

        echo "\n\nloading content"; flush();


        //$dom = HtmlDomParser::str_get_html( $content )->plaintext;
        echo "\n\nloaded content"; flush();


        $dom = HtmlDomParser::str_get_html( $content );

        $table=$dom->find('table.mdcTable tbody',0);


        echo $table->plaintext;
//        $elems = $dom->find('table.mdcTable');
//
//
//        foreach($elems as $article):
//
//        endforeach;
//
//        //$this->parseHtmlTableIntoArray( $content );
//
//
//        print_r( $elem->plaintext );

     //   echo $dom;
    }

    /**
     * @param \Carbon\Carbon $date
     */
    protected function setUrl( Carbon $date ) {
        $this->url = $this->urlPrefix . $date->format( 'Ymd' ) . $this->urlSuffix;
    }


    protected function parseHtmlTableIntoArray( string $pageContent ) {

        $dom = HtmlDomParser::str_get_html( $pageContent );

        $table = $dom->find('table[class=mdcTable]');


        print_r( $table );

        //discard white space
//        $dom->preserveWhiteSpace = false;
//
//        //the table by its tag name
//        $tables = $dom->getElementsByTagName('table');
//
//        //get all rows from the table
//        $rows = $tables->item(0)->getElementsByTagName('tr');
//
//        // loop over the table rows
//        foreach ($rows as $row)
//        {
//            // get each column by tag name
//            $cols = $row->getElementsByTagName('td');
//            // echo the values
//            echo $cols->item(0)->nodeValue.'<br />';
//            echo $cols->item(1)->nodeValue.'<br />';
//            echo $cols->item(2)->nodeValue;
//        }


    }
}
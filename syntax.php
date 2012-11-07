<?php
/**
 * Plugin Tab: Inserts a pagebreak into the document for every <pagebreak> it encounters.  Based on the tab plugin by Tim Skoch <timskoch@hotmail.com>
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Jonathan McBride and Chris Sturm - The University of Texas at Austin
 *
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_pagebreak extends DokuWiki_Syntax_Plugin {

    function getType(){
        return 'substition';
    }

    function getSort(){
        return 999;
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<pagebreak>',$mode,'plugin_pagebreak');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        switch ($state) {
            case DOKU_LEXER_ENTER :
                break;
            case DOKU_LEXER_MATCHED :
                break;
            case DOKU_LEXER_UNMATCHED :
                break;
            case DOKU_LEXER_EXIT :
                break;
            case DOKU_LEXER_SPECIAL :
                break;
        }
        return array();
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        if ($mode === 'xhtml') {
            $renderer->doc .= '<br class="plugin_pagebreak" />';
            return true;
        }

        if ($mode === 'odt') {
            $renderer->autostyles['dw_plugin_pagebreak'] =
            '<style:style style:name="dw_plugin_pagebreak" style:family="paragraph" style:parent-style-name="Text_20_body">
                <style:paragraph-properties fo:break-before="page"/>
             </style:style>';

            $renderer->p_close();
            $renderer->doc .= '<text:p text:style-name="dw_plugin_pagebreak" />';
            $renderer->p_open();
        }

        return false;
    }
}
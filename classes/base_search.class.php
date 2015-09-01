<?php

include $_SERVER['DOCUMENT_ROOT'] . '/classes/base_search.strategies.class.php';

class BaseSearch extends Connection {

    public $id;
    public $paginatePages = 0;
    public $allSources;
    public $vars;

    private $build_url_method;
    private $reshape_method;

    public function __construct($vars){
        $this->create($vars);
    }

    public function create($vars) {
        if(!isset($vars['q']) || $vars['q'] == "") $vars['q'] = "*";

        $this->vars = $vars;
        /*
        $this->uid = isset($vars['uid']) ? $vars['uid'] : NULL;
        $this->community = isset($vars['community']) ? $vars['community'] : NULL;
        $this->category = isset($vars['category']) ? $vars['category'] : NULL;
        $this->subcategory = isset($vars['subcategory']) ? $vars['subcategory'] : NULL;
        $this->source = isset($vars['nif']) ? $vars['nif'] : NULL;
        $this->query = isset($vars['q']) ? $vars['q'] : '*';
        $this->display = isset($vars['l']) ? $vars['l'] : NULL;
        $this->filter = isset($vars['filter']) ? $vars['filter'] : NULL;
        $this->facet = isset($vars['facet']) ? $vars['facet'] : NULL;
        $this->page = isset($vars['page']) ? $vars['page'] : NULL;
        $this->parent = isset($vars['parent']) ? $vars['parent'] : NULL;
        $this->child = isset($vars['child']) ? $vars['child'] : NULL;
        $this->fullscreen = isset($vars['fullscreen']) ? $vars['fullscreen'] : NULL;
        $this->sort = isset($vars['sort']) ? $vars['sort'] : NULL;
        $this->column = isset($vars['column']) ? $vars['column'] : NULL;
        $this->exclude = isset($vars['exclude']) ? $vars['exclude'] : NULL;
        $this->include = isset($vars['include']) ? $vars['include'] : NULL;
        $this->preference = isset($vars['preference']) ? $vars['preference'] : NULL;
        $this->stripped = isset($vars['stripped']) ? $vars['stripped'] : NULL;
        */
    }

    public function doSearch($method){
        $this->setStrategy($method);
        $search_url = $this->build_url_method->buildURL($this->vars);
        $xml = $this->getXML($search_url);
        $results = $this->reshape_method->parseXML($xml, $this->vars);
        return $results;
    }

    private function setStrategy($method){
        switch($method){
            case "summary":
                $this->build_url_method = new StrategyURLSummary();
                $this->reshape_method = new StrategyXMLSummary();
                break;
            case "single_source":
                $this->build_url_method = new StrategyURLSingleSource();
                $this->reshape_method = new StrategyXMLSingleSource();
                break;
            default:
                throw new Exception("Bad search method given");
        }
    }

    private function getXML($search_url){
        $xml_all = Connection::multi(Array($search_url));
        $data_xml = BaseSearch::xml2array(simplexml_load_string($xml_all[0]));
        return $data_xml;
    }

    static public function xml2array($xmlObject, $out = array()){
            foreach ( (array) $xmlObject as $index => $node )
                $out[$index] = ( is_object ( $node ) ||  is_array ( $node ) ) ? BaseSearch::xml2array ( $node ) : $node;
    
            return $out;
    } 
}
?>

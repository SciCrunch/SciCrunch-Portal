<?php

class SearchTest extends Test {

    public $initVars = array(
        'uid' => 10,
        'category' => 'My Category',
        'subcategory' => 'My Subcategory',
        'nif' => null,
        'q' => '*',
        'l' => false,
        'filter' => array('Resource Type:data'),
        'facet' => false,
        'page' => 1,
        'parent' => false,
        'child' => false,
        'fullscreen' => 'true',
        'sort' => null,
        'column' => false,
        'exclude' => false,
        'include' => false,
        'preference' => false,
        'stripped' => false
    );

    public $communityVars = array(
        'id' => 100,
        'uid' => 1,
        'name' => 'Test Community',
        'shortName' => 'Test',
        'description' => 'Some testing community',
        'portalName' => 'test',
        'url' => 'http://test.com',
        'private' => 1,
        'access' => 1,
        'logo' => 'test.png',
        'resourceView' => 1,
        'dataView' => 1,
        'literatureView' => 1,
        'time' => 1
    );

    public $categoryVars = array(
        'id' => 100,
        'uid' => 1,
        'cid' => 5,
        'x' => 2,
        'y' => 3,
        'z' => 4,
        'category' => 'My Category',
        'subcategory' => 'My Subcategory',
        'source' => 'nlx_144509-1',
        'filter' => '&filter=Something:hello',
        'facet' => '&facet=Other:bye',
        'active' => 2,
        'time' => 1
    );

    public function mapping($key) {
        switch ($key) {
            case 'nif':
                return 'source';
            case 'q':
                return 'query';
            default:
                return $key;
        }
    }

    function __construct($output, $dependencies) {
        parent::__construct($output, $dependencies);
    }

    public function runTests($isXML) {
        $html = '';
        $this->dependencyChecks();
        if ($isXML) {
            $html .= '<class><name>Search Class</name><relies><class>Category Class</class><class>Community Class</class></relies><uses></uses><tests>';
            $html .= $this->outputXML($this->initTest());
            $html .= $this->outputXML($this->htmlFacetTest());
            $html .= $this->outputXML($this->tableParamsTest());
            $html .= $this->outputXML($this->resourceURLsTest());
            $html .= '</tests></class>';
        } else {
            $html .= $this->setUpOutputTable('Search Class', array('Category Class', 'Community Class'), array());
            $html .= $this->outputResult($this->initTest());
            $html .= $this->outputResult($this->htmlFacetTest());
            $html .= $this->outputResult($this->tableParamsTest());
            $html .= $this->outputResult($this->resourceURLsTest());
            $html .= $this->closeTable();
        }
        return $html;
    }

    public function initTest() {
        $vars['title'] = 'Constructor Test';
        $vars['description'] = 'Tests the constructor of the search class to make sure variables properly link to the
            right members.';

        $category = new Category();
        $category->create($this->categoryVars);

        $community = new Community();
        $community->create($this->communityVars);

        $community->urlTree[$category->category]['subcategories'][$category->subcategory]['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $category->source . '.xml?orMultiFacets=true' . $category->filter . $category->facet;
        $community->urlTree[$category->category]['subcategories'][$category->subcategory]['nif'][] = $category->source;
        $community->urlTree[$category->category]['subcategories'][$category->subcategory]['objects'][] = $category;
        $community->views[$category->source] = true;

        $this->initVars['community'] = $community;

        $search = new Search();
        $search->create($this->initVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($search->$field != $value) {
                $vars['status'] = 0;
                $vars['reason'] .= "The variable $field didn't match.<br/>";
            }
        }

        if ($vars['reason'] == '')
            $vars['reason'] = 'Constructor output matches expectations.';

        return $vars;
    }

    public function htmlFacetTest() {

        $vars['title'] = 'HTML Current Facet Test';
        $vars['description'] = 'Tests the HTML output of getting the current facets.';

        $search = new Search();
        $search->create($this->initVars);

        $facetHTML = '<h3>Current Facets</h3><ul class="list-unstyled">';
        $facetHTML .= '<li>' . $this->initVars['filter'][0] . '<a href="/' . $this->initVars['community']->portalName . '/' . $this->initVars['category'] . '/' . $this->initVars['subcategory'] . '/search?q=%2A&l=&fullscreen=true"><i class="fa red-x fa-times-circle"></i></a></li>';
        $facetHTML .= '</ul><hr style="margin-top:10px;margin-bottom:15px;"/>';

        if ($search->currentFacets($this->initVars) == $facetHTML) {
            $vars['status'] = 2;
            $vars['reason'] = 'Facet HTML matched expectations';
        } else {
            $vars['status'] = 1;
            $vars['reason'] = 'Facet HTML did not match expectations.';
        }

        return $vars;

    }

    public function tableParamsTest() {
        $vars['title'] = 'Getting Table Parameters Test';
        $vars['description'] = 'This tests whether the parameters on the service for tables matches my expectations.';

        $search = new Search();
        $search->create($this->initVars);

        $tableParams = '&exportType=all&filter=' . rawurlencode($this->initVars['filter'][0]) . '&q=' . rawurlencode($this->initVars['q']);

        if ($search->getTableParams() == $tableParams) {
            $vars['status'] = 2;
            $vars['reason'] = 'Table Params matched expectations';
        } else {
            $vars['status'] = 1;
            $vars['reason'] = 'Table Params did not match expectations.';
        }

        return $vars;
    }

    public function resourceURLsTest() {
        $vars['title'] = 'Community Resources URLs';
        $vars['description'] = 'This test makes sure the Community Resource web service URLs are constructed properly
          to make sure the proper data is returned.';

        $returnVars['urls'] = array(ENVIRONMENT.'/v1/federation/data/nlx_144509-1.xml?orMultiFacets=true&filter=Something:hello&facet=Other:bye&exportType=all&filter=Resource%20Type%3Adata&q=%2A&offset=0&count=20');
        $returnVars['counts'] = array(20);
        $returnVars['nif'] = array('nlx_144509-1');
        $returnVars['subcategories'] = array('My Subcategory');

        $search = new Search();
        $search->create($this->initVars);

        $vars['reason'] = '';
        $vars['status'] = 2;

        if ($search->resourceCategoryURLS() != $returnVars) {
            $vars['status'] = 0;
            $vars['reason'] .= 'Community Resource URLs did not matched expectations.';
        }

        $returnVars['counts'] = array(1);
        $returnVars['subcategories'] = array('My Category|My Subcategory');

        if ($search->allCategorySearch() != $returnVars) {
            $vars['status'] = 0;
            //$other = $search->allCategorySearch();
            //echo $returnVars['urls'][0].' : '.$other['urls'][0];
            $vars['reason'] .= 'All Resource URLs did not matched expectations.';
            //$vars['reason'] .= json_encode($search->allCategorySearch());
        }

        if ($vars['status'] == 2)
            $vars['reason'] = 'All Categories and Single subcategory URLs met expectations.';

        return $vars;

    }

}

?>
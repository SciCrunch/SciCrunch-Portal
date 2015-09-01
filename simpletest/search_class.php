<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/classes.php");

class SearchTest extends UnitTestCase{

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

    public function testInit() {
        // Constructor Test
        // Tests the constructor of the search class to make sure variables properly link to the right members.

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

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            $this->assertEqual($search->$field, $value);
        }
    }

    public function testHtmlFacet() {
        // HTML Current Facet Test
        // Tests the HTML output of getting the current facets.

        $search = new Search();
        $search->create($this->initVars);

        $facetHTML = '<h3>Current Facets</h3><ul class="list-unstyled">';
        $facetHTML .= '<li>' . $this->initVars['filter'][0] . '<a href="/' . $this->initVars['community']->portalName . '/' . $this->initVars['category'] . '/' . $this->initVars['subcategory'] . '/search?q=%2A&l=&fullscreen=true"><i class="fa red-x fa-times-circle"></i></a></li>';
        $facetHTML .= '</ul><hr style="margin-top:10px;margin-bottom:15px;"/>';

        $this->assertEqual($search->currentFacets($this->initVars), $facetHTML);
    }

    public function testTableParams() {
        // Getting Table Parameters Test
        // This tests whether the parameters on the service for tables matches my expectations.

        $search = new Search();
        $search->create($this->initVars);

        $tableParams = '&exportType=all&filter=' . rawurlencode($this->initVars['filter'][0]) . '&q=' . rawurlencode($this->initVars['q']);

        $this->assertEqual($search->getTableParams(), $tableParams);
    }

    public function testResourceURLs() {
        // Community Resources URLs
        // This test makes sure the Community Resource web service URLs are constructed properly to make sure the proper data is returned.

        $returnVars['urls'] = array(ENVIRONMENT.'/v1/federation/data/nlx_144509-1.xml?orMultiFacets=true&filter=Something:hello&facet=Other:bye&exportType=all&filter=Resource%20Type%3Adata&q=%2A&offset=0&count=20');
        $returnVars['counts'] = array(20);
        $returnVars['nif'] = array('nlx_144509-1');
        $returnVars['subcategories'] = array('My Subcategory');

        $search = new Search();
        $search->create($this->initVars);

        $this->assertEqual($search->resourceCategoryURLS(), $returnVars);

        //$returnVars['counts'] = array(1);
        $returnVars['subcategories'] = array('My Category|My Subcategory');

        $this->assertEqual($search->allCategorySearch(), $returnVars);
    }
}

?>

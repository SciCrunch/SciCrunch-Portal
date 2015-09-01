<?php

class Search extends Connection {

    public $id;
    public $uid;
    public $community;
    public $category;
    public $subcategory;
    public $source;
    public $query;
    public $display;
    public $filter;
    public $facet;
    public $sort;
    public $preference;
    public $column;
    public $exclude;
    public $include;
    public $parent;
    public $child;
    public $page;
    public $fullscreen;
    public $paginatePages = 0;
    public $allSources;
    public $stripped;

    public $vars;

    public function create($vars) {
        //print_r($vars);
        $this->vars = $vars;
        $this->uid = $vars['uid'];
        $this->community = $vars['community'];
        $this->category = $vars['category'];
        $this->subcategory = $vars['subcategory'];
        $this->source = $vars['nif'];
        $this->query = $vars['q'];
        $this->display = $vars['l'];
        $this->filter = $vars['filter'];
        $this->facet = $vars['facet'];
        $this->page = $vars['page'];
        $this->parent = $vars['parent'];
        $this->child = $vars['child'];
        $this->fullscreen = $vars['fullscreen'];
        $this->sort = $vars['sort'];
        $this->column = $vars['column'];
        $this->exclude = $vars['exclude'];
        $this->include = $vars['include'];
        $this->preference = $vars['preference'];
        $this->stripped = $vars['stripped'];
    }

    public function currentFacets($vars) {
        if ($this->facet || $this->filter || $this->sort || ($this->parent && !$this->source)) {
            $html = '<h3>Current Facets</h3>';
            $html .= '<ul class="list-unstyled">';
            if(is_array($this->filter) || is_object($this->filter)){
                foreach ($this->filter as $filter) {
                    $newVars = $vars;
                    $newVars['filter'] = array_diff($vars['filter'], array($filter));
                    $html .= '<li>' . $filter . '<a href="' . $this->generateURL($newVars) . '"><i class="fa red-x fa-times-circle"></i></a></li>';
                }
            }

            if(is_array($this->facet) || is_object($this->facet)){
                foreach ($this->facet as $filter) {
                    $newVars = $vars;
                    $newVars['facet'] = array_diff($vars['facet'], array($filter));
                    $html .= '<li>' . $filter . '<a href="' . $this->generateURL($newVars) . '"><i class="fa red-x fa-times-circle"></i></a></li>';
                }
            }


            if ($this->column && $this->sort) {
                $newVars = $vars;
                $newVars['column'] = null;
                $newVars['sort'] = null;
                $html .= '<li>' . $this->column . ' : ';
                if ($this->sort == 'asc')
                    $html .= 'Ascending';
                else
                    $html .= 'Descending';
                $html .= '<a href="' . $this->generateURL($newVars) . '"><i class="fa red-x fa-times-circle"></i></a></li>';
            }

            $html .= '</ul><hr style="margin-top:10px;margin-bottom:15px;"/>';
        } else {
            $html = '';
        }

        return $html;
    }

    public function currentSpecialFacets($vars, $base) {
        if ($this->facet || $this->filter || $this->sort || $this->parent) {
            $html = '<h3>Current Facets</h3>';
            $html .= '<ul class="list-unstyled">';
            foreach ($this->filter as $filter) {
                $newVars = $vars;
                $newVars['filter'] = array_diff($vars['filter'], array($filter));
                $html .= '<li>' . $filter . '<a href="' . $this->generateSpecialURL($newVars, $base) . '"><i class="fa red-x fa-times-circle"></i></a></li>';
            }

            foreach ($this->facet as $filter) {
                $newVars = $vars;
                $newVars['facet'] = array_diff($vars['facet'], array($filter));
                $html .= '<li>' . $filter . '<a href="' . $this->generateSpecialURL($newVars, $base) . '"><i class="fa red-x fa-times-circle"></i></a></li>';
            }


            if ($this->column && $this->sort) {
                $newVars = $vars;
                $newVars['column'] = null;
                $newVars['sort'] = null;
                $html .= '<li>' . $this->column . ' : ';
                if ($this->sort == 'asc')
                    $html .= 'Ascending';
                else
                    $html .= 'Descending';
                $html .= '<a href="' . $this->generateSpecialURL($newVars, $base) . '"><i class="fa red-x fa-times-circle"></i></a></li>';
            }

            $html .= '</ul><hr style="margin-top:10px;margin-bottom:15px;"/>';
        } else {
            $html = '';
        }

        return $html;
    }

    public function getTableParams() {
        if (!$this->source)
            $params = '&exportType=all';
        else
            $params = '';

        if ($this->facet) {
            foreach ($this->facet as $facet) {
                $params .= '&facet=' . rawurlencode($facet);
            }
        }
        if ($this->filter) {
            foreach ($this->filter as $filter) {
                $params .= '&filter=' . rawurlencode($filter);
            }
        }
        if ($this->exclude) {
            if ($this->exclude == 'synonyms')
                $params .= '&expandSynonyms=false&includeInferred=false';
        }
        if ($this->include) {
            if ($this->include == 'acronyms')
                $params .= '&expandAcronyms=true';
        }
        if ($this->column && $this->sort) {
            $params .= '&sortField=' . rawurlencode($this->column);
            if ($this->sort == 'asc')
                $params .= '&sortAsc=true';
            else
                $params .= '&sortAsc=false';
        }
        $params .= '&q=' . rawurlencode($this->query);

        return $params;
    }

    public function doSearch() {
        switch ($this->category) {
            case "data":
                return $this->dataDirect();
            case "literature":
                return $this->literatureSearch();
            default:
                return $this->resourceDirect();
        }
    }

    /** Data Page Searches */

    public function dataDirect() {
        if ($this->fullscreen && $this->source) {
            return $this->dataFullTable();
        } elseif ($this->source) {
            return $this->dataTableSearch();
        } else {
            return $this->dataPageSearch();
        }
    }

    public function dataFullTable() {
        $params = $this->getTableParams();
        $vars['urls'][] = ENVIRONMENT . '/v1/federation/facets/' . $this->source . '.xml?' . $params;
        $vars['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $this->source . '.xml?exportType=all&highlight=true&count=50&offset=' . (($this->page - 1) * 50) . $params;
        return $this->doTableSearch($vars, 50);
    }

    public function dataTableSearch() {
        $params = $this->getTableParams();
        if ($this->page > 1)
            $move = '&offset=' . (($this->page - 1) * 20) . '&count=20';
        else
            $move = '&count=20';
        $vars['urls'][] = ENVIRONMENT . '/v1/federation/facets/' . $this->source . '.xml?orMultiFacets=true' . $params;
        $vars['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $this->source . '.xml?orMultiFacets=true&highlight=true' . $params . $move;
        $vars['csv'] = ENVIRONMENT . '/v1/federation/data/' . $this->source . '.csv?orMultiFacets=true&highlight=true' . $params . $move;

        return $this->doTableSearch($vars, 20);
    }

    public function checkLocalStore($url) {
        $this->connect();
        $return = $this->select('search_data', array('xml'), 's', array($url), 'where url=?');
        $this->close();

        if (count($return) > 0) {
            return $return[0]['xml'];
        } else {
            return false;
        }
    }

    public function insertIntoLocalStore($url, $xml) {
        $this->connect();
        $this->insert('search_data', 'iss', array(null, $url, $xml));
        $this->close();
    }

    public function clearLocalStore() {
        $this->connect();
        $this->delete('search_data', null, array(), '');
        $this->close();
    }

    public function dataPageSearch() {
        $url = ENVIRONMENT . '/v1/federation/search.xml?q=' . rawurlencode($this->query);
        if ($this->exclude) {
            if ($this->exclude == 'synonyms')
                $url .= '&includeSynonyms=false';
            elseif ($this->exclude == 'acronyms')
                $url .= '&includeAcronyms=true';
        }

        $string = $this->checkLocalStore($url);
        if ($string) {
            $xml = simplexml_load_string($string);
        } else {
            $xml = simplexml_load_file($url);
            if ($xml && (int)$xml->result['total'] > 0)
                $this->insertIntoLocalStore($url, $xml->asXML());
        }


        if ($xml) {
            $finalArray['count'] = (int)$xml->result['total'];
            $finalArray['expansion'] = $this->getQueryInfo($xml);
            foreach ($xml->result->categories->category as $category) {
                $finalArray['categories'][(string)$category['parent']][(string)$category['category']] = (int)$category->count;
            }
            $prefAlp = array();
            $prefCov = array();
            $elseAlp = array();
            $elseCov = array();
            foreach ($xml->result->results->result as $result) {
                $string_nifid = (string)$result['nifId'];
                if (!$finalArray['sources'][$string_nifid]) {
                    if (!$this->parent || ($this->parent == (string)$result['parentCategory'] && $this->child == (string)$result['category'])) {
                        $finalArray['sources'][$string_nifid] = array(
                            'child' => (string)$result['category'],
                            'parent' => (string)$result['parentCategory'],
                            'name' => (string)$result['db'] . ': ' . $result['indexable'],
                            'count' => (string)$result->count,
                            'cover' => sprintf("%.2f%%", ((int)$result->count / (int)$result->totalCount) * 100)
                        );
                        if (!$this->preference && $this->community->views[$string_nifid]) {
                            $prefAlp[(string)$result['db'] . ': ' . $result['indexable']] = $string_nifid;
                            $prefCov[$string_nifid] = (int)$result->count / (int)$result->totalCount;
                        } else {
                            $elseAlp[(string)$result['db'] . ': ' . $result['indexable']] = $string_nifid;
                            $elseCov[$string_nifid] = (int)$result->count / (int)$result->totalCount;
                        }
                    }
                }
                else{
                    if(!$this->parent || ($this->parent == (string)$result['parentCategory'] && $this->child == (string)$result['category'])){
                        $finalArray['hidden-sources'][$string_nifid] = array(
                            'child' => (string)$result['category'],
                            'parent' => (string)$result['parentCategory'],
                            'name' => (string)$result['db'] . ': ' . $result['indexable'],
                            'count' => (string)$result->count,
                            'cover' => sprintf("%.2f%%", ((int)$result->count / (int)$result->totalCount) * 100)
                        );
                        if (!$this->preference && $this->community->views[$string_nifid]) {
                            $prefAlp[(string)$result['db'] . ': ' . $result['indexable']] = $string_nifid;
                            $prefCov[$string_nifid] = (int)$result->count / (int)$result->totalCount;
                        } else {
                            $elseAlp[(string)$result['db'] . ': ' . $result['indexable']] = $string_nifid;
                            $elseCov[$string_nifid] = (int)$result->count / (int)$result->totalCount;
                        }
                    }
                }
            }

            if (count($prefAlp) > 0) {
                ksort($prefAlp, SORT_STRING | SORT_FLAG_CASE);
                //arsort($prefCov);
            }

            ksort($elseAlp, SORT_STRING | SORT_FLAG_CASE);
            //arsort($elseCov);


            if (count($prefAlp) > 0) {
                $finalArray['alphabetical'] = $prefAlp + $elseAlp;
                $finalArray['cover'] = $prefCov + $elseCov;
            } else {
                $finalArray['alphabetical'] = $elseAlp;
                $finalArray['cover'] = $elseCov;
            }
        }
        return $finalArray;
    }

    /** Resource Page Searches */

    public function resourceDirect() {
        if ($this->source) {
            $return0 = $this->resourceTableSearch($this->source);
            if($return0) $final = $this->doTableSearch($return0,20);
            else $final=NULL;
        } elseif ($this->category == 'Any') {
            $return0 = $this->allCategorySearch();
            $final = $this->doCategorySearch($return0);
        } else {
            $return0 = $this->resourceCategoryURLS();
            $final = $this->doCategorySearch($return0);
        }
        return $final;
    }

    public function resourceTableSearch($source) {
        $params = $this->getTableParams();
        $end = -1;
        if ($this->page > 1)
            $move = '&highlight=true&offset=' . (($this->page - 1) * 20) . '&count=20';
        else
            $move = '&highlight=true&count=20';

        $found_url = $this->buildFoundURL($source, $params);
        if(is_null($found_url)) return NULL;    // searched a source not in our community, return nothing
        $vars['urls'][0] = str_replace('/data/', '/facets/', $found_url) . $params;
        $vars['urls'][1] = $found_url . $params . $move;
        $vars['csv'] = str_replace('.xml', '.csv', $found_url) . $params;
        return $vars;
    }

    public function doTableSearch($vars, $amount) {
        //print_r($vars);

        $final_array = Array();
        $finalArray['export'] = $vars['csv'];
        $this->buildFacetFromURL($vars['urls'][0], $finalArray);
        $this->buildDataFromURL($vars['urls'][1], $finalArray, $amount);
        return $finalArray;
    }

    public function allCategorySearch() {
        $params = $this->getTableParams();
        $count = 0;
        $urlHolder = array();
        $subHolder = array();
        $nifHolder = array();
        $max = 0;
        //print_r($this->community->urlTree);
        $urls = 0;
        foreach ($this->community->urlTree as $category => $arr) {
            if (count($arr['urls']) > 0) {
                foreach ($arr['urls'] as $url) {
                    $urls++;
                }
            }
            if (count($arr['subcategories']) > 0) {
                foreach ($arr['subcategories'] as $sub => $array) {
                    foreach ($array['urls'] as $i => $url) {
                        $urls++;
                    }
                }
            }
        }
        $theCount = ceil(20 / $urls);
        foreach ($this->community->urlTree as $category => $arr) {
            if (count($arr['urls']) > 0) {
                $num = '&offset=' . ($theCount * ($this->page - 1)).'&count=' . $theCount;

                foreach ($arr['urls'] as $url) {
                    $urlHolder[$count][] = $url . $params . $num;
                    $countHolder[$count][] = $theCount;
                }
                $subHolder[$count] = array_fill(0, count($urlHolder[$count]), $category . '|');
                $nifHolder[$count] = $arr['nif'];
                $count++;
                $max = count($urlHolder[0]);
            }
            if (count($arr['subcategories']) > 0) {
                foreach ($arr['subcategories'] as $sub => $array) {
                    $num = '&offset=' . ($theCount * ($this->page - 1)).'&count=' . $theCount;
                    foreach ($array['urls'] as $i => $url) {
                        $urlHolder[$count][] = $url . $params . $num;
                        $subHolder[$count][] = $category . '|' . $sub;
                        //echo $array['nif'][$i]."<br/>";
                        $nifHolder[$count][] = $array['nif'][$i];
                        $countHolder[$count][] = $theCount;
                    }
                    if (count($urlHolder[$count]) > $max)
                        $max = count($urlHolder[$count]);
                    $count++;
                }
            }
        }

        //print_r($nifHolder);
        //echo "\n";
        //print_r($urlHolder);
        foreach ($urlHolder as $i => $urlArr) {
            foreach ($urlArr as $j => $url4) {
                if ($urlHolder[$i][$j]) {
                    $vars['urls'][] = $urlHolder[$i][$j];
                    $vars['subcategories'][] = $subHolder[$i][$j];
                    $vars['nif'][] = $nifHolder[$i][$j];
                    $vars['counts'][] = $countHolder[$i][$j];
                }
            }
        }
        //print_r($vars);
        return $vars;
    }

    public function resourceCategoryURLS() {
        $params = $this->getTableParams();
        if ($this->subcategory) {
            $num = ceil(20 / count($this->community->urlTree[$this->category]['subcategories'][$this->subcategory]['urls']));
            $params .= '&offset=' . ($num * ($this->page - 1)) . '&count=' . $num;
            foreach ($this->community->urlTree[$this->category]['subcategories'][$this->subcategory]['urls'] as $url) {
                $vars['urls'][] = $url . $params;
                $vars['counts'][] = $num;
            }
            $vars['nif'] = $this->community->urlTree[$this->category]['subcategories'][$this->subcategory]['nif'];
            foreach ($vars['urls'] as $url) {
                $vars['subcategories'][] = $this->subcategory;
            }
        } else {
            $count = 0;
            $urlHolder = array();
            $subHolder = array();
            $nifHolder = array();
            $max = 0;

            $divide = count($this->community->urlTree[$this->category]['subcategories']);

            if (count($this->community->urlTree[$this->category]['urls']) > 0) {

                $divide += 1;
                $upper = ceil(20 / $divide);
                $lower = ceil($upper / count($this->community->urlTree[$this->category]['urls']));
                $num = '&count=' . $lower . '&offset=' . (($this->page - 1) * $lower);

                foreach ($this->community->urlTree[$this->category]['urls'] as $url) {
                    $urlHolder[0][] = $url . $params . $num;
                    $countHolder[0][] = $lower;
                }
                $subHolder[0] = array_fill(0, count($urlHolder[0]), 'CURRENT');
                $nifHolder[0] = $this->community->urlTree[$this->category]['nif'];
                $count++;
                $max = count($urlHolder[0]);
            } else {
                $upper = ceil(20 / $divide);
            }
            if (count($this->community->urlTree[$this->category]['subcategories']) > 0) {
                foreach ($this->community->urlTree[$this->category]['subcategories'] as $sub => $array) {
                    $lower = ceil($upper / count($array['urls']));
                    $num = '&count=' . $lower . '&offset=' . (($this->page - 1) * $lower);
                    foreach ($array['urls'] as $i => $url) {
                        $urlHolder[$count][] = $url . $params . $num;
                        $subHolder[$count][] = $sub;
                        $nifHolder[$count][] = $array['nif'][$i];
                        $countHolder[$count][] = $lower;
                    }
                    if (count($urlHolder[$count]) > $max)
                        $max = count($urlHolder[$count]);
                    $count++;
                }
            }
            for ($j = 0; $j < $max; $j++) {
                for ($i = 0; $i < count($urlHolder); $i++) {
                    if ($urlHolder[$i][$j]) {
                        $vars['urls'][] = $urlHolder[$i][$j];
                        $vars['subcategories'][] = $subHolder[$i][$j];
                        $vars['nif'][] = $nifHolder[$i][$j];
                        $vars['counts'][] = $countHolder[$i][$j];
                    }
                }
            }
        }
        return $vars;
    }

    public function getQueryInfo($xml) {
        $finalArray['hasExpo'] = false;
        //print_r($xml);
        foreach ($xml->query->clauses->clauses as $clause) {
            $expo = array();
            foreach ($clause->expansion->expansion as $expansion) {
                $expo[] = (string)$expansion;
            }
            $finalArray['query'][] = array(
                'id' => (string)$clause['id'],
                'label' => (string)$clause->query,
                'expansion' => $expo
            );
            if (count($expo) > 0) {
                $finalArray['hasExpo'] = true;
            }
        }
        return $finalArray;
    }

    public function doCategorySearch($vars) {

        $orderArray = array();
        $count = 0;
        foreach ($vars['urls'] as $i => $url) {
            $string = $this->checkLocalStore($url);
            if ($string) {
                $theFiles[$i] = $string;
            } else {
                $orderArray[$count] = $i;
                $urls[$count] = $url;
                $count++;
            }
        }

        if (count($urls) > 0) {
            $files = Connection::multi($urls);

            foreach ($files as $i => $file) {
                $this->insertIntoLocalStore($urls[$i], $file);
                $theFiles[$orderArray[$i]] = $file;
            }
        }

        $first = true;
        $snippets = array();

        $max = 0;
        $total = 0;
        $maxPages = 0;
        foreach ($theFiles as $i => $file) {
            //echo $vars['urls'][$i];
            $xml = simplexml_load_string($file);
            if ($xml) {
                if ($first) {
                    $finalArray['expansion'] = $this->getQueryInfo($xml);
                    $first = false;
                }
                //echo $vars['urls'][$i].' : '.(int)$xml->result['resultCount'];
                $total += (int)$xml->result['resultCount'];

                if ($this->subcategory) {
                    $tree[$this->category][$this->subcategory][$this->allSources[$vars['nif'][$i]]->getTitle()] = (int)$xml->result['resultCount'];
                    $translate[$this->allSources[$vars['nif'][$i]]->getTitle()] = $vars['nif'][$i];
                } else {
                    $spliter = explode('|', $vars['subcategories'][$i]);
                    if ($this->category == 'Any') {
                        if (count($spliter) > 1 && $spliter[1] != '') {
                            $tree[$this->category][$spliter[0]][$spliter[1]][$this->allSources[$vars['nif'][$i]]->getTitle()] = (int)$xml->result['resultCount'];
                            $translate[$this->allSources[$vars['nif'][$i]]->getTitle()] = $vars['nif'][$i];
                        } else {
                            $tree[$this->category][$spliter[0]]['Not in a Subcategory'][$this->allSources[$vars['nif'][$i]]->getTitle()] = (int)$xml->result['resultCount'];
                            $translate[$this->allSources[$vars['nif'][$i]]->getTitle()] = $vars['nif'][$i];
                        }
                    } else {
                        if ($vars['subcategories'][$i] == '') {
                            $tree[$this->category]['Not in a Subcategory'][$this->allSources[$vars['nif'][$i]]->getTitle()] = (int)$xml->result['resultCount'];
                            $translate[$this->allSources[$vars['nif'][$i]]->getTitle()] = $vars['nif'][$i];
                        } else
                            $tree[$this->category][$vars['subcategories'][$i]][$this->allSources[$vars['nif'][$i]]->getTitle()] = (int)$xml->result['resultCount'];
                        $translate[$this->allSources[$vars['nif'][$i]]->getTitle()] = $vars['nif'][$i];
                    }
                }

                if ($finalArray['info']['counts']['nif'][$vars['nif'][$i]]){
                    $finalArray['info']['counts']['nif'][$vars['nif'][$i]] += (int)$xml->result['resultCount'];
                }else{
                    $finalArray['info']['counts']['nif'][$vars['nif'][$i]] = (int)$xml->result['resultCount'];
                }
                //print_r($finalArray);

                //echo $vars['counts'][$i]);
                if (ceil((int)$xml->result['resultCount'] / $vars['counts'][$i]) > $maxPages) {
                    $maxPages = ceil((int)$xml->result['resultCount'] / $vars['counts'][$i]);
                }

                if ((int)$xml->result['resultCount'] > 0){
                    if(isset($finalArray['info']['nifDirect'][$vars['nif'][$i]])){
                        array_push($finalArray['info']['nifDirect'][$vars['nif'][$i]], $vars['subcategories'][$i]);
                    }else{
                        $finalArray['info']['nifDirect'][$vars['nif'][$i]] = Array($vars['subcategories'][$i]);
                    }
                }

                if ($finalArray['info']['counts']['subs'][$vars['subcategories'][$i]])
                    $finalArray['info']['counts']['subs'][$vars['subcategories'][$i]] += (int)$xml->result['resultCount'];
                else
                    $finalArray['info']['counts']['subs'][$vars['subcategories'][$i]] = (int)$xml->result['resultCount'];

                $snippet = new Snippet();
                //echo "<br/>".$vars['view'][$i]."<br/>";
                if (!isset($snippets[$vars['nif'][$i]])) {
                    $snippet = new Snippet();
                    $snippet->getSnippetByView($this->community->id, $vars['nif'][$i]);
                    if ($snippet->raw) {
                        $snippet->splitParts();
                    } else {
                        $snippet->raw = '<xml><title></title><description></description><citation></citation><url></url></xml>';
                        $snippet->splitParts();
                    }
                    $snippets[$vars['nif'][$i]] = $snippet;
                } else
                    $snippet = $snippets[$vars['nif'][$i]];

                //print_r($snippets);

                foreach ($xml->result->results->row as $row) {
                    $snippet->resetter();
                    foreach ($row->data as $data) {
                        $snippet->replace((string)$data->name, (string)$data->value);
                        if ((string)$data->name == 'v_uuid')
                            $uuid = (string)$data->value;
                    }
                    $snippet->splitParts();
                    $results[$i][] = array(
                        'snippet' => $snippet->snippet,
                        'nif' => $vars['nif'][$i],
                        'subcategory' => $vars['subcategories'][$i],
                        'uuid' => $uuid
                    );
                }
                if (count($results[$i]) > $max)
                    $max = count($results[$i]);
            }
        }

        foreach ($tree as $level1 => $array1) {
            $lev1 = array();
            foreach ($array1 as $level2 => $array2) {
                if (!is_array($array2)) {
                    if ($level1 == 'Any') { // /Any/Category
                        $newVars = $this->vars;
                        $newVars['subcategory'] = false;
                        $newVars['nif'] = false;
                        $newVars['category'] = $level2;
                    } else { // /Category/Subcategory
                        $newVars = $this->vars;
                        if($level2 != 'Not in a Subcategory')
                            $newVars['subcategory'] = $level2;
                        else
                            $newVars['subcategory'] = false;
                        $newVars['nif'] = false;
                        $newVars['category'] = $level1;
                    }
                    $lev1[] = array('name' => $level2, 'size' => $array2, 'url' => $this->generateURL($newVars));
                } else {
                    $lev2 = array();
                    foreach ($array2 as $level3 => $array3) {
                        if (!is_array($array3)) {
                            if ($level1 == 'Any') { // /Any/Category/Subcategory
                                $newVars = $this->vars;
                                if($level3 != 'Not in a Subcategory')
                                    $newVars['subcategory'] = $level3;
                                else
                                    $newVars['subcategory'] = false;
                                $newVars['nif'] = false;
                                $newVars['category'] = $level2;
                            } else { // /Category/Subcategory/Source
                                $newVars = $this->vars;
                                if($level2 != 'Not in a Subcategory')
                                    $newVars['subcategory'] = $level2;
                                else
                                    $newVars['subcategory'] = false;
                                $newVars['nif'] = $translate[$level3];
                                $newVars['category'] = $level1;
                            }
                            $lev2[] = array('name' => $level3, 'size' => $array3, 'url' => $this->generateURL($newVars));
                        } else {
                            $lev3 = array();
                            foreach ($array3 as $level4 => $array4) {
                                $newVars = $this->vars;
                                if ($level3 == 'Not in a Subcategory')
                                    $newVars['subcategory'] = false;
                                else
                                    $newVars['subcategory'] = $level3;
                                $newVars['nif'] = $translate[$level4];
                                $newVars['category'] = $level2;
                                $lev3[] = array('name' => $level4, 'size' => $array4, 'url' => $this->generateURL($newVars));
                            }
                            $newVars = $this->vars;
                            if ($level1 == 'Any') {
                                if ($level3 == 'Not in a Subcategory')
                                    $newVars['subcategory'] = false;
                                else
                                    $newVars['subcategory'] = $level3;
                                $newVars['nif'] = false;
                                $newVars['category'] = $level2;
                            } else {
                                if ($level2 == 'Not in a Subcategory')
                                    $newVars['subcategory'] = false;
                                else
                                    $newVars['subcategory'] = $level2;
                                $newVars['nif'] = $translate[$level3];
                                $newVars['category'] = $level2;
                            }
                            $lev2[] = array('name' => $level3, 'children' => $lev3, 'url' => $this->generateURL($newVars));
                        }
                    }
                    if ($level1 == 'Any') {
                        $newVars['subcategory'] = false;
                        $newVars['nif'] = false;
                        $newVars['category'] = $level2;
                    } else {
                        if ($level2 == 'Not in a Subcategory')
                            $newVars['subcategory'] = false;
                        else
                            $newVars['subcategory'] = $level2;
                        $newVars['nif'] = false;
                        $newVars['category'] = $level1;
                    }
                    $lev1[] = array('name' => $level2, 'children' => $lev2, 'url' => $this->generateURL($newVars));
                }
            }
            $lev0 = array('name' => $level1, 'children' => $lev1);
        }
        $finalArray['info']['tree'] = $lev0;

        //echo $max;
        $this->paginatePages = $maxPages;

        if (count($results) > 1) {
            for ($j = 0; $j < $max; $j++) {
                foreach ($results as $i => $dont) {
                    if ($results[$i][$j]) {
                        $finalArray['results'][] = $results[$i][$j];
                    }
                }
            }
        } else {
            $finalArray['results'] = end($results);
        }
        $finalArray['total'] = $total;

        // build facets if only one source had results
        $single = false;
        $source = false;
        foreach($finalArray['info']['counts']['nif'] as $nif => $n){
            if($n > 0){
                if(!$source){
                    $source = $nif;
                    $single = true;
                }else{
                    $single = false;
                    break;
                }
            }
        }
        if($single){
          $table_urls = $this->resourceTableSearch($source);
          if($table_urls) $this->buildFacetFromURL($table_urls['urls'][0], $finalArray);
        }

        return $finalArray;
    }

    public function literatureSearch() {
        $url = ENVIRONMENT . '/v1/literature/search.xml?q=' . $this->query . '&highlight=true&facetCount=1&count=20&offset=' . (($this->page - 1) * 20);
        foreach ($this->facet as $facet) {
            $splits = explode(':', $facet);
            switch ($splits[0]) {
                case 'Author':
                    $url .= '&authorFilter=' . join(':', array_slice($splits, 1));
                    break;
                case 'Journal':
                    $url .= '&journalFilter=' . join(':', array_slice($splits, 1));
                    break;
                case 'Year':
                    $url .= '&yearFilter=' . join(':', array_slice($splits, 1));
                    break;
                case 'Section':
                    $url .= '&section=' . join(':', array_slice($splits, 1));
                    break;
                case 'Search':
                    $url .= '&searchFullText=true';
                    break;
                case 'Require':
                    $url .= '&requireFullText=true';
                    break;
            }
            if ($this->exclude) {
                if ($this->exclude == 'synonyms')
                    $url .= '&includeSynonyms=false';
                elseif ($this->exclude == 'acronyms')
                    $url .= '&includeAcronyms=true';
            }
        }
        return $this->doLitSearch($url);
    }

    public function doLitSearch($url) {
        //echo $url;

        $string = $this->checkLocalStore($url);
        if ($string) {
            $xml = simplexml_load_string($string);
        } else {
            $xml = simplexml_load_file($url);
            $this->insertIntoLocalStore($url, $xml->asXML());
        }

        if ($xml) {
            $finalArray['expansion'] = $this->getQueryInfo($xml);
            $finalArray['total'] = (int)$xml->result['resultCount'];
            $this->paginatePages = ceil((int)$xml->result['resultCount'] / 20);
            foreach ($xml->result->facets as $type) {
                if ((string)$type['category'] == 'author_facet')
                    $label = 'Author';
                elseif ((string)$type['category'] == 'year')
                    $label = 'Year';
                elseif ((string)$type['category'] == 'journalShort_facet')
                    $label = 'Journal';
                elseif ((string)$type['category'] == 'grantAgency_facet')
                    $label = 'Grant';

                foreach ($type->facets as $facet) {
                    if($label=='Year')
                        $finalArray['json'][] = array('year'=>(int)$facet,'num'=>(int)$facet['count']);
                    $finalArray['facets'][$label][] = array('text' => (string)$facet, 'count' => (int)$facet['count']);
                }
            }
            $finalArray['facets']['Section'] = array('Title', 'Abstract', 'Introduction', 'Methods', 'Results', 'Supplement', 'Appendix', 'Contributions', 'Background', 'Commentary', 'Funding', 'Limitations', 'Caption');
            foreach ($xml->result->publications->publication as $pub) {
                $paper = array();
                $paper['pmid'] = (string)$pub['pmid'];
                $paper['firstAuthor'] = (string)$pub->authors->author;
                foreach ($pub->authors->author as $author) {
                    $paper['authors'][] = (string)$author;
                }
                $paper['journal'] = (string)$pub->journal;
                $paper['journalShort'] = (string)$pub->journalShort;
                $paper['date'] = array(
                    'day' => (string)$pub->day,
                    'month' => (string)$pub->month,
                    'year' => (string)$pub->year
                );
                foreach ($pub->meshHeadings->meshHeading as $mesh) {
                    $paper['mesh'][] = (string)$mesh;
                }
                $paper['title'] = (string)$pub->title;
                $paper['abstract'] = (string)$pub->abstract;
                $finalArray['papers'][] = $paper;
            }
        }
        $finalArray['export'] = str_replace('.xml', '.ris', $url);
        return $finalArray;
    }

    public function getParams() {
        $params = '';
        if ($this->facet) {
            foreach ($this->facet as $facet) {
                $params .= '&facet[]=' . $facet;
            }
        }
        if ($this->filter) {
            foreach ($this->filter as $filter) {
                $params .= '&filter[]=' . $filter;
            }
        }
        if ($this->parent && $this->child) {
            $params .= '&parent=' . $this->parent . '&child=' . $this->child;
        }
        if ($this->exclude) {
            $params .= '&exclude=' . $this->exclude;
        }
        if ($this->include) {
            $params .= '&include=' . $this->include;
        }
        if (!isset($this->page) || $this->page != 1) {
            $params .= '&page=' . $this->page;
        }
        if ($this->fullscreen == 'true') {
            $params .= '&fullscreen=true';
        }
        if ($this->sort) {
            $params .= '&sort=' . $this->sort;
        }
        if ($this->preference) {
            $params .= '&preference=' . $this->preference;
        }
        if (isset($this->column) && isset($this->sort)) {
            $params .= '&column=' . $this->column . '&sort=' . $this->sort;
        }
        return $params;
    }

    public function generateURL($vars) {
        //print_r($vars);
        $params = '';
        if ($vars['facet']) {
            foreach ($vars['facet'] as $facet) {
                $params .= '&facet[]=' . $facet;
            }
        }
        if ($vars['filter']) {
            foreach ($vars['filter'] as $filter) {
                $params .= '&filter[]=' . $filter;
            }
        }
        if ($vars['parent'] && $vars['child']) {
            $params .= '&parent=' . $vars['parent'] . '&child=' . $vars['child'];
        }
        if ($vars['exclude']) {
            $params .= '&exclude=' . $vars['exclude'];
        }
        if ($vars['include']) {
            $params .= '&include=' . $vars['include'];
        }
        
		// "About" pages need more than just the community name in the URL
		if ($vars['type'] == 'about') {
			$url = '/' . $vars['portalName'] . "/" . $vars['type'] . "/" . $vars['title'] . "/" . $vars['id'];
		} else {
			$url = '/' . $this->community->portalName;
		}	

        if(isset($vars['stripped'])&&$vars['stripped']=='true')
            $url .= '/stripped';
        if ($vars['category']) {
            $url .= '/' . $vars['category'];
        }
        if ($vars['subcategory']) {
            $url .= '/' . $vars['subcategory'];
        }
        if ($vars['nif']) {
            $url .= '/source/' . $vars['nif'];
        }
        if (!isset($vars['page']) || $vars['page'] != 1) {
            $url .= '/page/' . $vars['page'];
        }
        if ($vars['view'] && $vars['uuid']) {
            $url .= '/record/' . $vars['view'] . '/' . $vars['uuid'];
        }
        if ($vars['fullscreen'] == 'true') {
            $params .= '&fullscreen=true';
        }
        if ($vars['sort']) {
            $params .= '&sort=' . $vars['sort'];
        }
        if ($vars['preference']) {
            $params .= '&preference=' . $vars['preference'];
        }
        if (isset($vars['column']) && isset($vars['sort'])) {
            $params .= '&column=' . $vars['column'] . '&sort=' . $vars['sort'];
        }

		// 'About' pages aren't search related, although they do have filters ...
		if ($vars['type'] == 'about') {
	        $url .= '?l=' . rawurlencode($vars['l']) . $params;
		} else {
	        $url .= '/search?q=' . rawurlencode($vars['q']) . '&l=' . rawurlencode($vars['l']) . $params;
		}  

        return $url;
    }

    public function generateSpecialURL($vars, $base) {
        //print_r($vars);
        $params = '';
        if ($vars['facet']) {
            foreach ($vars['facet'] as $facet) {
                $params .= '&facet[]=' . $facet;
            }
        }
        if ($vars['filter']) {
            foreach ($vars['filter'] as $filter) {
                $params .= '&filter[]=' . $filter;
            }
        }
        if ($vars['parent'] && $vars['child']) {
            $params .= '&parent=' . $vars['parent'] . '&child=' . $vars['child'];
        }
        if ($vars['exclude']) {
            $params .= '&exclude=' . $vars['exclude'];
        }
        if ($vars['include']) {
            $params .= '&include=' . $vars['include'];
        }
        $url = $base;

        if ($vars['subcategory']) {
            $url .= '/' . $vars['subcategory'];
        }
        if ($vars['nif']) {
            $url .= '/source/' . $vars['nif'];
        }
        if (!isset($vars['page']) || $vars['page'] != 1) {
            $params .= '&page=' . $vars['page'];
        }
        if ($vars['sort']) {
            $params .= '&sort=' . $vars['sort'];
        }
        if ($vars['preference']) {
            $params .= '&preference=' . $vars['preference'];
        }
        if (isset($vars['column']) && isset($vars['sort'])) {
            $params .= '&column=' . $vars['column'] . '&sort=' . $vars['sort'];
        }
        $url .= '?q=' . $vars['q'] . '&l=' . $vars['l'] . $params;
        return $url;
    }

    public function paginate($vars) {
        $html = '<div class="text-left">';
        $html .= '<ul class="pagination">';
        $newVars = $vars;
        $newVars['page'] = $this->page - 1;

        if ($this->page > 1)
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">«</a></li>';
        else
            $html .= '<li><a href="javascript:void(0)">«</a></li>';

        if ($this->page - 1 > 0) {
            $start = $this->page - 1;
        } else
            $start = 1;
        if ($this->page + 1 < $this->paginatePages) {
            $end = $this->page + 2;
        } else
            $end = $this->paginatePages;

        if ($start > 1) {
            $html .= '<li><a href="javascript:void(0)">..</a></li>';
        }

        for ($i = $start; $i < $end; $i++) {
            $newVars = $vars;
            $newVars['page'] = $i;

            if ($i == $this->page) {
                $html .= '<li class="active"><a href="javascript:void(0)">' . $i . '</a></li>';
            } else {
                $html .= '<li><a href="' . $this->generateURL($newVars) . '">' . $i . '</a></li>';
            }
        }

        if ($end < $this->paginatePages) {
            $html .= '<li><a href="javascript:void(0)">..</a></li>';
        }

        $newVars = $vars;
        $newVars['page'] = $this->page + 1;
        if ($this->page < $this->paginatePages)
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">»</a></li>';
        else
            $html .= '<li><a href="javascript:void(0)">»</a></li>';


        $html .= '</ul></div>';

        return $html;
    }

    public function paginateLong($vars) {
        $html = '<div class="text-left">';
        $html .= '<ul class="pagination">';
        $newVars = $vars;
        $newVars['page'] = $this->page - 1;

        if ($this->page > 1)
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">«</a></li>';
        else
            $html .= '<li><a href="javascript:void(0)">«</a></li>';

        if ($this->page - 3 > 0) {
            $start = $this->page - 3;
        } else
            $start = 1;
        if ($this->page + 3 < $this->paginatePages) {
            $end = $this->page + 3;
        } else
            $end = $this->paginatePages;

        if ($start > 2) {
            $newVars = $vars;
            $newVars['page'] = 1;
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">1</a></li>';
            $newVars['page'] = 2;
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">2</a></li>';
            $html .= '<li><a href="javascript:void(0)">..</a></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $newVars = $vars;
            $newVars['page'] = $i;

            if ($i == $this->page) {
                $html .= '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
            } else {
                $html .= '<li><a href="' . $this->generateURL($newVars) . '">' . number_format($i) . '</a></li>';
            }
        }

        if ($end < $this->paginatePages - 3) {
            $html .= '<li><a href="javascript:void(0)">..</a></li>';
            $newVars = $vars;
            $newVars['page'] = $this->paginatePages - 1;
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">' . number_format($this->paginatePages - 1) . '</a></li>';
            $newVars['page'] = $this->paginatePages;
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">' . number_format($this->paginatePages) . '</a></li>';
        }

        $newVars = $vars;
        $newVars['page'] = $this->page + 1;
        if ($this->page < $this->paginatePages)
            $html .= '<li><a href="' . $this->generateURL($newVars) . '">»</a></li>';
        else
            $html .= '<li><a href="javascript:void(0)">»</a></li>';


        $html .= '</ul></div>';

        return $html;
    }

    public function getResultText($type, $args, $expansion, $vars) {
        $html = '';
        if ($type == 'resource') {
            if ($args[1] == 0) {
                $html .= '<div class="alert alert-warning fade in text-center">
                            <h4 style="text-transform: none;font-size:24px">Please Search Again!</h4>';
                $html .= '<p style="text-transform: none;padding:10px;font-size:18px;">We could not find any records in this particular category for your search: <b>' . $vars['q'] . '</b>. We recommend you try in
                              another category or try in More Resource or Literature.</p>';
                $html .= '<p>';

                $newVars = $vars;
                $newVars['subcategory'] = false;
                $newVars['nif'] = false;

                if ($vars['category'] != 'Any') {
                    $newVars['category'] = 'Any';
                    $html .= '<a class="btn-u" href="' . $this->generateURL($newVars) . '">Try All Categories</a> ';
                }
                $newVars['category'] = 'data';
                $html .= '<a class="btn-u btn-u-red" href="' . $this->generateURL($newVars) . '">Try More Resources</a>';

                $newVars['category'] = 'literature';
                $html .= ' <a class="btn-u btn-u-sea" href="' . $this->generateURL($newVars) . '">Try Literature</a>';

                $html .= ' <a class="btn-u btn-u-purple" href="/'.$this->community->portalName.'/about/resource">Or Add A Resource</a>';
                $html .= '</p>
                        </div>';
                return $html;
            } else {
                $html .= 'on page ' . $this->page . ' showing ' . number_format($args[0]) . ' out of ' . number_format($args[1]) . ' results from ' . number_format($args[2]) . ' sources';
            }
        } elseif ($type == 'data') {
            if ($args[0] == 0) {
                $html .= '<div class="alert alert-warning fade in text-center">
                            <h4 style="text-transform: none;font-size:24px">Please Search Again!</h4>';
                $html .= '<p style="text-transform: none;padding:10px;font-size:18px;">We could not find any data for your search: <b>' . $vars['q'] . '</b>. We recommend you try in
                              Literature to see if there are papers about it.</p>';
                $html .= '<p>';

                $newVars = $vars;
                $newVars['subcategory'] = false;
                $newVars['nif'] = false;

                $newVars['category'] = 'literature';
                $html .= ' <a class="btn-u btn-u-sea" href="' . $this->generateURL($newVars) . '">Try Literature</a>';
                $html .= '</p>
                        </div>';
                return $html;
            } else
                $html .= 'showing <span class="data-number" data="' . number_format($args[0]) . '">' . number_format($args[0]) . '</span> results across <span data="' . number_format($args[1]) . '" class="source-number">' . number_format($args[1]) . '</span> data source(s)';
        } elseif ($type == 'literature') {
            if ($args[0] == 0) {

                $html .= '<div class="alert alert-warning fade in text-center">
                            <h4 style="text-transform: none;font-size:24px">Please Search Again!</h4>';
                $html .= '<p style="text-transform: none;padding:10px;font-size:18px;">We could not find any papers for your search: <b>' . $vars['q'] . '</b>. We recommend you try
                              your search across the Community Resources or More Resources.</p>';
                $html .= '<p>';

                $newVars = $vars;
                $newVars['subcategory'] = false;
                $newVars['nif'] = false;

                $newVars['category'] = 'Any';
                $html .= '<a class="btn-u btn-u-red" href="' . $this->generateURL($newVars) . '">Try Community Resources</a>';

                $newVars['category'] = 'data';
                $html .= ' <a class="btn-u btn-u-sea" href="' . $this->generateURL($newVars) . '">Try More Resources</a>';
                $html .= '</p>
                        </div>';
                return $html;
            } else {
                if ($args[0] < $this->page * 20)
                    $html .= 'showing ' . number_format(($this->page - 1) * 20 + 1) . ' - ' . number_format($args[0]) . ' papers out of ' . number_format($args[0]) . ' papers';
                else
                    $html .= 'showing ' . number_format(($this->page - 1) * 20 + 1) . ' - ' . number_format($this->page * 20) . ' papers out of ' . number_format($args[0]) . ' papers';
            }
        } elseif ($type == 'table') {
            if ($args[0] == 0) {

                $html .= '<div class="alert alert-warning fade in text-center">
                            <h4 style="text-transform: none;font-size:24px">Please Search Again!</h4>';
                $html .= '<p style="text-transform: none;padding:10px;font-size:18px;">We could not find any records in this particular source for your search: <b>' . $vars['q'] . '</b>. We recommend you try your
                              search across all Community Sources, or More Resources, or Literature.</p>';
                $html .= '<p>';

                $newVars = $vars;
                $newVars['subcategory'] = false;
                $newVars['nif'] = false;

                $newVars['category'] = 'Any';
                $html .= '<a class="btn-u" href="' . $this->generateURL($newVars) . '">Try Community Resources</a> ';

                $newVars['category'] = 'data';
                $html .= '<a class="btn-u btn-u-red" href="' . $this->generateURL($newVars) . '">Try More Resources</a>';

                $newVars['category'] = 'literature';
                $html .= ' <a class="btn-u btn-u-sea" href="' . $this->generateURL($newVars) . '">Try Literature</a>';

                $html .= ' <a class="btn-u btn-u-purple" href="/'.$this->community->portalName.'/about/resource">Or Add A Resource</a>';

                $html .= '</p>
                        </div>';
                return $html;
            } else
                $html .= number_format($args[0]) . ' Results';
        }
        if ($expansion['hasExpo'] || $this->exclude || $this->exclude) {
            $html .= ' with the ';
            $html .= '<div class="btn-group">
                        <button type="button" class="btn-u btn-u-purple dropdown-toggle tut-expansion" data-toggle="dropdown">
                            Query Expansion
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">';
            if ($this->exclude && $this->exclude == 'synonyms') {
                $newVars = $vars;
                $newVars['exclude'] = null;
                $html .= '<li><a href="' . $this->generateURL($newVars) . '"><i class="fa fa-plus-circle" style="color:#00bb00"></i> Add Synonyms</a></li>';
            } else {
                $newVars = $vars;
                $newVars['exclude'] = 'synonyms';
                $html .= '<li><a href="' . $this->generateURL($newVars) . '"><i class="fa fa-times-circle" style="color:#bb0000"></i> Remove Synonyms</a></li>';
            }
            if ($this->include && $this->include == 'acronyms') {
                $newVars = $vars;
                $newVars['include'] = null;
                $html .= '<li style="margin-bottom:10px"><a href="' . $this->generateURL($newVars) . '"><i class="fa fa-times-circle" style="color:#bb0000"></i> Remove Acronyms</a></li>';
            } else {
                $newVars = $vars;
                $newVars['include'] = 'acronyms';
                $html .= '<li style="margin-bottom:10px"><a href="' . $this->generateURL($newVars) . '"><i class="fa fa-plus-circle" style="color:#00bb00"></i> Add Acronyms</a></li>';
            }
            $html .= '<li class="divider" style="margin:0;height:10px;border-top: 1px solid #bbb;background:#e5e5e5"></li>';

            foreach ($expansion['query'] as $array) {
                if (count($array['expansion']) > 0) {
                    foreach ($array['expansion'] as $expo) {
                        $html .= '<li style="background:#e5e5e5"><a>' . $expo . '</a></li>';
                    }
                } else {
                    $html .= '<li><a>No Expansion</a></li>';
                }
            }

            $html .= '</ul>
                    </div>';
        }
        return $html;
    }

    public function buildFacetFromURL($url, &$finalArray){
        // load the xml from the url string into an xml object
        $xml = $this->checkLocalStore($url);
        if(!$xml){
            $xml_all = Connection::multi(Array($url));
            $xml = $xml_all[0];
            $this->insertIntoLocalStore($url, $xml);
        }
        $facetXML = simplexml_load_string($xml);

        // parse the xml
        if ($facetXML) {
            foreach ($facetXML->facets as $facets) {
                foreach ($facets->facets as $facet) {
                    $finalArray['facets'][(string)$facets['category']][] = array('value' => (string)$facet, 'count' => (int)$facet['count']);
                    $tree[(string)$facets['category']][] = array('name' => (string)$facet, 'size' => (int)$facet['count']);
                }
            }
            foreach($tree as $category=>$array){
                $level2 = array();
                foreach($array as $arr){
                    $newVars = $this->vars;
                    $newVars['facet'][] = rawurlencode($category).':'.rawurlencode($arr['name']);
                    $level2[] = array('name'=>rawurlencode($arr['name']),'size'=>$arr['size'],'url'=>$this->generateURL($newVars));
                }
                $level1[] = array('name'=>rawurlencode($category),'children'=>$level2);
            }
            $finalArray['graph'] = array('name'=>'Facets','children'=>$level1);
        }
    }

    public function buildDataFromURL($url, &$finalArray, $amount){
        // load the xml from the url string into an xml object
        $xml = $this->checkLocalStore($url);
        if(!$xml){
            $xml_all = Connection::multi(Array($url));
            $xml = $xml_all[0];
            $this->insertIntoLocalStore($url, $xml);
        }
        $dataXML = simplexml_load_string($xml);

        // parse the xml
        if ($dataXML) {
            $finalArray['expansion'] = $this->getQueryInfo($dataXML);
            $finalArray['total'] = (int)$dataXML->result['resultCount'];
            $count = 0;
            foreach ($dataXML->result->results->row as $row) {
                $numCol = 0;
                foreach ($row->data as $data) {
                    $finalArray['table'][$count][(string)$data->name] = (string)$data->value;
                    $numCol++;
                }
                $count++;
            }
            $this->paginatePages = ceil((int)$dataXML->result['resultCount'] / $amount);
        }
    }

    public function buildFoundURL($source, $params){
        $base_url = "nif_services_federation_data_endpoint" . $source . ".xml?orMultiFacets=true";
        $facets_filters = $params;
        $url_tree = $this->community->urlTree;
        $found = false;
        $param_types = $this->getParamsTypes($params);

        if ($this->subcategory) {	// if there's a subcategory
            foreach ($url_tree[$this->category]['subcategories'][$this->subcategory]['nif'] as $i => $nif) {
                if ($nif == $source) {
                    $found = true;
                    $facets_filters .= $this->checkFilterFacets($url_tree[$this->category]['subcategories'][$this->subcategory]['objects'][$i]->filter, $param_types);
                    $facets_filters .= $this->checkFilterFacets($url_tree[$this->category]['subcategories'][$this->subcategory]['objects'][$i]->facet, $param_types);
                }
            }
        }
        if(!$found) {	// if there is no subcategory,  search category
            $category = $url_tree[$this->category];
            foreach ($category['nif'] as $i => $nif){
                if ($nif == $source) {
                    $found = true;
                    $facets_filters .= $this->checkFilterFacets($category['objects'][$i]->filter, $params_types);
                    $facets_filters .= $this->checkFilterFacets($category['objects'][$i]->facet, $param_types);
                }
            }
            foreach($category['subcategories'] as $i => $subcat){   // and that categories subcategories
                foreach($subcat['nif'] as $j => $subnif){
                    if($subnif == $source){
                        $found = true;
                        $facets_filters .= $this->checkFilterFacets($subcat['objects'][$j]->filter, $param_types);
                        $facets_filters .= $this->checkFilterFacets($subcat['objects'][$j]->facet, $param_types);
                    }
                }
            }
        }
        if(!$found){	// this condition will only be met in the resource view (not table view) when query is found in a single subcategory source
            foreach($url_tree[$this->category]['subcategories'] as $subname => $subvals){
                foreach($subvals['nif'] as $i => $nif){
                    if($nif == $source){
                        $found = true;
                        $facets_filters .= $this->checkFilterFacets($subvals['objects'][$i]->filter, $param_types);
                        $facets_filters .= $this->checkFilterFacets($subvals['objects'][$i]->facet, $param_types);
                    }
                }
            }
        }
        if(!$found){	// catch all, searches every category and subcategory if all else fails
            foreach($url_tree as $i => $category){
                foreach($category['nif'] as $j => $nif){
                    if($nif == $source){
                        $found = true;
                        $facets_filters .= $this->checkFilterFacets($category['objects'][$j]->filter, $param_types);
                        $facets_filters .= $this->checkFilterFacets($category['objects'][$j]->facet, $param_types);
                    }
                }
                if($category['subcategories']){
                    foreach($category['subcategories'] as $j => $subcategory){
                        foreach($subcategory['nif'] as $k => $nif2){
                            if($nif2 == $source){
                                $found = true;
                                $facets_filters .= $this->checkFilterFacets($subcategory['objects'][$k]->filter, $param_types);
                                $facets_filters .= $this->checkFilterFacets($subcategory['objects'][$k]->facet, $param_types);
                            }
                        }
                    }
                }
            }
        }
        if(!$found) return NULL;
        $full_url = $base_url . $facets_filters;
        return $full_url;
    }

    private function getParamsTypes($params){
        // returns a list of params that are already in the request url, therefore cannot be used again
        $params = explode("&", $params);
        $return_params = Array();
        foreach($params as $param){
            $param_split = preg_split("/(:|%3A)/", $param);
            if(!in_array($param_split[0], $return_params) && $param_split[0] != ""){
                array_push($return_params, $param_split[0]);
            }
        }
        return $return_params;
    }

    private function checkFilterFacets($ff, $param_types){
        $ff_split = preg_split("/(:|%3A)/", $ff);
        $ff_type = $ff_split[0];
        if($ff_type[0] == "&") $ff_type = substr($ff_type, 1);  // remove ampersand
        if(in_array($ff_type, $param_types)) return "";
        return $ff;
    }
}

?>

<?php

interface StrategyURL{
    public function buildURL(&$vars);
}
interface StrategyXML{
    public function parseXML(&$xml, &$vars);
}

class StrategyURLSummary implements StrategyURL{
    public function buildURL(&$vars){
        // q - query
        $query_url = ENVIRONMENT . "/v1/summary?q=" . $vars['q'];
        return $query_url;
    }
}

class StrategyXMLSummary implements StrategyXML{
    public function parseXML(&$xml, &$vars){
        $categories = $this->reshapeCategories($xml);
        $sources = $this->reshapeSources($xml);
        $sources = $this->collapseSources($sources);
        $total_count = $xml['result']['federationSummary']['@attributes']['total'];
        $results = Array('categories' => $categories, 'sources' => $sources, 'totalCount' => $total_count);
        return $results;
    }

    private function reshapeCategories(&$data_xml){
        $categories = $data_xml['result']['federationSummary']['categories']['category'];
        $reshape = Array();
        foreach($categories as $cat){
            $attributes = $cat['@attributes'];
            $new_cat = Array('count' => $cat['count']);
            foreach($attributes as $idx => $att) $new_cat[$idx] = $att;
            array_push($reshape, $new_cat);
        }
        return $reshape;
    }

    private function reshapeSources(&$data_xml){
        $sources = $data_xml['result']['federationSummary']['results']['result'];
        $reshape = Array();
        if(isset($sources['@attributes']) && isset($sources['count']) && isset($sources['totalCount'])){	// this means that there is only one data source
            $new_cat = $this->reshapeSingleSource($sources);
            array_push($reshape, $new_cat);
        }else{																								// multiple data sources
            foreach($sources as $source){
                $new_cat = $this->reshapeSingleSource($source);
                array_push($reshape, $new_cat);
            }
        }
        return $reshape;
    }

    private function reshapeSingleSource(&$source){
        $new_cat = Array('count' => $source['count'], 'totalCount' => $source['totalCount']);
        $attributes = $source['@attributes'];
        foreach($attributes as $idx => $att) $new_cat[$idx] = $att;
        return $new_cat;
    }

    private function collapseSources(&$sources){
        $found_idx = Array();
        $collapsed_sources = Array();
        foreach($sources as $source){
            if(isset($found_idx[$source['nifId']])){	// append found source to categories of existing source
                $idx = $found_idx[$source['nifId']];
                array_push($collapsed_sources[$idx]['category'], $source['category']);
                array_push($collapsed_sources[$idx]['parentCategory'], $source['parentCategory']);
            }else{										// add new source
                 array_push($collapsed_sources, $source);
                 $idx = count($collapsed_sources) - 1;
                 $collapsed_sources[$idx]['category'] = Array($collapsed_sources[$idx]['category']);
                 $collapsed_sources[$idx]['parentCategory'] = Array($collapsed_sources[$idx]['parentCategory']);
                 $found_idx[$source['nifId']] = $idx;
            }
        }
        return $collapsed_sources;
    }
}

class StrategyURLSingleSource implements StrategyURL{
    public function buildURL(&$vars){
        // source - array of nif ids (only first one is used though)
        // q - query
        $default_results_per_page = 20;
        $count = isset($vars['results_per_page']) && is_numeric($vars['results_per_page']) ? (int) $vars['results_per_page'] : $default_results_per_page;	// deefault 20
        $offset = isset($vars['page_number']) && is_numeric($vars['page_number']) ? (int) $vars['page_number'] * $count : 0;
        $query_url = ENVIRONMENT . '/v1/federation/data/' . $vars['source'][0] . '?q=' . $vars['q'];
        return $query_url;
    }
}

class StrategyXMLSingleSource implements StrategyXML{
    public function parseXML(&$xml, &$vars){
        $count = $xml['@attributes']['resultCount'];
        $results = $xml['results']['row'];
        $results = $this->reshapeResults($results);
        $return_array = Array("count" => $count, "results" => $results);
        return $return_array;
    }

    public function reshapeResults(&$results){
        $new_results = Array();
        foreach($results as $res){
            $data = Array();
            foreach($res['data'] as $datum){
                $data[$datum['name']] = $datum['value'];
            }
            array_push($new_results, $data);
        }
        return $new_results;
    }
}

?>

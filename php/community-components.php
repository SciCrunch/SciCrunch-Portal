<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../classes/classes.php';

$holder = new Community();
$communities = $holder->searchCommunities(false,'', 0, 200);

$community = new Community();
$community->id = 0;
$community->name = 'SciCrunch';
$communities['results'][] = $community;

foreach ($communities['results'] as $community) {
    $component = new Component();
    $components = $component->getByCommunity($community->id);
    if ($components)
        continue;
    $vars['uid'] = 0;
    $vars['cid'] = $community->id;
    $vars['disabled'] = 0;

    $vars['component'] = 0;
    $vars['position'] = 0;
    $vars['image'] = null;
    $vars['text1'] = null;
    $vars['text2'] = null;
    $vars['text3'] = null;
    $vars['color1'] = null;
    $vars['color2'] = null;
    $vars['color3'] = null;
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;

    //header
    $vars['component'] = 0;
    $vars['position'] = 0;
    $vars['image'] = null;
    $vars['text1'] = null;
    $vars['text2'] = null;
    $vars['text3'] = null;
    $vars['color1'] = '72c02c';
    $vars['color2'] = null;
    $vars['color3'] = null;
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

    //footer
    $vars['component'] = 92;
    $vars['position'] = 0;
    $vars['image'] = null;
    $vars['text1'] = '<p>Our Information</p>';
    $vars['text2'] = 'Welcome to the ' . $community->name . ' Community.';
    $vars['text3'] = null;
    $vars['color1'] = '72c02c';
    $vars['color2'] = '585f69';
    $vars['color3'] = '3e4753';
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

    //Breadcrumbs
    $vars['component'] = 100;
    $vars['position'] = 0;
    $vars['image'] = null;
    $vars['text1'] = null;
    $vars['text2'] = null;
    $vars['text3'] = null;
    $vars['color1'] = 'ffffff';
    $vars['color2'] = '72c02c';
    $vars['color3'] = '585f69';
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

    //Search Box
    $vars['component'] = 101;
    $vars['position'] = 0;
    $vars['image'] = null;
    $vars['text1'] = 'Search through ' . $community->shortName;
    $vars['text2'] = 'Selecting a term from the dropdown will search for that entity exactly';
    $vars['text3'] = null;
    $vars['color1'] = '585f69';
    $vars['color2'] = '72c02c';
    $vars['color3'] = null;
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

    if ($community->id == 0) {
        $vars['component'] = 10;
        $vars['position'] = 0;
        $vars['image'] = null;
        $vars['text1'] = null;
        $vars['text2'] = null;
        $vars['text3'] = null;
        $vars['color1'] = '72c02c';
        $vars['color2'] = '585f69';
        $vars['color3'] = '3e4753';
        $vars['icon1'] = null;
        $vars['icon2'] = null;
        $vars['icon3'] = null;
        $component->create($vars);
        $component->insertDB();
    } else {
        $vars['component'] = 12;
        $vars['position'] = 0;
        $vars['image'] = null;
        $vars['text1'] = 'Discover New Things';
        $vars['text2'] = 'Search for data related to your query';
        $vars['text3'] = null;
        $vars['color1'] = 'ffffff';
        $vars['color2'] = '72c02c';
        $vars['color3'] = null;
        $vars['icon1'] = null;
        $vars['icon2'] = null;
        $vars['icon3'] = null;
        $component->create($vars);
        $component->insertDB();
    }

    //Goto Component
    $vars['component'] = 21;
    $vars['position'] = 1;
    if ($community->id == 0)
        $vars['image'] = '/create/resource';
    else
        $vars['image'] = '/' . $community->portalName . '/about/resource';
    $vars['text1'] = 'Register a Resource';
    $vars['text2'] = 'Add a resource to our resource registry to get an identifier for your resource and share it with others.';
    $vars['text3'] = 'Add Resource';
    $vars['color1'] = '72c02c';
    $vars['color2'] = '5fb611';
    $vars['color3'] = null;
    $vars['icon1'] = 'fa fa-plus';
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

    //Service Boxes
    $vars['component'] = 31;
    $vars['position'] = 2;
    $vars['image'] = null;
    if ($community->id == 0)
        $vars['text1'] = '<h2>Create Communities</h2><p>Create communities to create personalized data exploration portals for yourself or your group to work with</p>';
    else
        $vars['text1'] = '<h2>Search our Categories</h2><p>Search through data in a way unique to ' . $community->name . ' and find what is relevant to you.</p>';
    $vars['text2'] = '<h2>Share Resources</h2><p>Join the largest scientific resource registry and add, share, and search for new resources with your community.</p>';
    $vars['text3'] = '<h2>Receive Updates</h2><p>Join our community to receive updates, learn about our organization, see our tutorials and ask us questions.</p>';
    $vars['color1'] = null;
    $vars['color2'] = null;
    $vars['color3'] = null;
    if ($community->id == 0)
        $vars['icon1'] = 'fa fa-plus-circle';
    else
        $vars['icon1'] = 'fa fa-search';
    $vars['icon2'] = 'fa fa-globe';
    $vars['icon3'] = 'fa fa-database';
    $component->create($vars);
    $component->insertDB();

    //Counter
    $vars['component'] = 11;
    $vars['position'] = 3;
    $vars['image'] = null;
    $vars['text1'] = null;
    $vars['text2'] = null;
    $vars['text3'] = null;
    $vars['color1'] = null;
    $vars['color2'] = null;
    $vars['color3'] = null;
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

    //Page Box
    $vars['component'] = 34;
    $vars['position'] = 4;
    $vars['image'] = null;
    $vars['text1'] = 'About Us';
    if ($community->id != 0)
        $vars['text2'] = $community->description;
    else
        $vars['text2'] = 'SciCrunch is a community creation website the emphasizes sharing data within your community and to other communities. With a SciCrunch Community you get access to our extensive custom portals and 200+ data sources we have collected to tailor to your needs.';
    $vars['text3'] = null;
    $vars['color1'] = '72c02c';
    $vars['color2'] = null;
    $vars['color3'] = null;
    $vars['icon1'] = null;
    $vars['icon2'] = null;
    $vars['icon3'] = null;
    $component->create($vars);
    $component->insertDB();

}

?>
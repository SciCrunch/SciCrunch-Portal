# SciCrunch UI Code

The SciCrunch UI is done in PHP using the Unify Templating as the guide for designing the site. 

## Requirements
* PHP 5.2+ 
* MySQL

## Configuration Files
The following files will need to be modified to make SciCrunch work
* Google reCAPTCHA configuration
  * browsing/registry-edit.php
  * communities/ssi/registry.edit.php
  * communities/ssi/resource-form.php 
  * components/body/parts/pages/contact-form.php
  * create-pages/resource-form.php 
  * forms/resource-forms/resource-edit.php
  * forms/resource-forms/resource-submission.php

* Database endpoint, NIF services endpoint, SciGraph endpoint, and Google Analytics code
  * classes/classes.php
    * Information about SciGraph -> https://github.com/SciGraph/SciGraph
    * Information about NIF services -> http://neuinfo.org/developers/nif_web_services.shtm

* Various NIF services endpoint, Concept Map Service endpoint
  * classes/search.class.php
    * $base_url (nif services federation data endpoint)
  * communities/ssi/individual.source.page.php
    * $url (nif services federation data endpoint)
    * $url (concept map service endpoint)
  * communities/ssi/old.single-item.php
    * $url (nif_services_federation_data_service_endpoint) 
    * $url3 (nif_services_literature_service_endpoint)
  * communities/ssi/paper-view.php
    * $url (nif_services_literature_service_endpoint)
    * $url2 (nif_services_federation_data_service_endpoint)
  * communities/ssi/single-item.php
    * $url (nif_services_federation_data_service_endpoint)
    * $url3 (nif_services_literature_service_endpoint)
  * components/body/parts/pages/resource-view.php
    * $url3 (nif_services_literature_service_endpoint)
  * forms/updateSources.php
    * $dbImgThumbnailLocation (url_to_thumbnails)
    * $urls[] (concept_map_summary_service_endpoint)
  * php/field-edit.php
    * $url (scigraph_vocab_category_service)
  * profile/shared-pages/resource-pages/form-edit.php
    * $url (nif_services_vocab_category_service)
  * vars/dataSource.php
    * this file links sources to their thumbnail url, names of sources to IDs, and descriptions for sources
    * needs to be customized to your installation

## Folder Descriptions
* assets: The unify assets (JS, CSS for components)
* browsing: All files pertaining to SciCrunch Browse Tab
* classes: contains all the PHP classes
* communities: PHP code pertaining to Communities inside SciCrunch (homepage, search views)
* components: the PHP/HTML/CSS for community/SciCrunch components
* create-pages: the files pertaining to SciCrunch Create Tab
* css: SciCrunch/Community specific CSS Files
* faqs: The SciCrunch faqs pages
* forms: the PHP files that transforms the user input in HTML forms to the DB
* images: the SciCrunch specific images
* js: the SciCrunch/Community specific Javascript files
* php: Typically these are scripts called in the interface dynamically to fill dialog boxes
* profile: all files pertaining to the My Account Tab
* ssi: the server side includes for SciCrunch, namely the site wide header and footer
* upload: the folder to hold user uploaded files for communities and components
* validation: validation code to check form inputs
* vars: any created files that would be too expensive to query dynamically

## Commonly used variables
* uid = User ID: used a lot in classes
* cid = Community ID: used a lot in classes and functions
* component = Component ID: used in Component Data and tags to refer to the component it is part of
* nif = The View ID of a source (also source): used in Search Class and in communities

## Common Class Functions
* create(vars)
  * Description: The constructor of the class for brand new objects (used from input forms)
  * vars: a key:value array of column:value pairs for the object
* createFromRow(vars)
  * Description: The constructor of the class for objects gotten from the DB
  * vars: a key:value array of column:value pairs from the DB table
* insertDB()
  * Description: Used to handle the specific insertion of a brand new object into the DB
* updateDB()
  * Description: Used to handle the updating of this object in a DB
* getByID(id)
  * Description: Used to get a single record from the DB by a given ID
  * id: the unique ID for an object in the DB

## Interface DB Model
  The interface composed of HTML, CSS, and Javascript. These are client*side code in that the server passes the code
  to a User's browser to interpret (hence differences in how things look across browsers). Client side code can be
  viewed and altered by the user, while server side code is never shown to the user. PHP is server side code in that
  the server runs the PHP code on the server and the result of the run should be HTML or a response telling the server
  where to go instead. You can use PHP code and HTML code within each other, but PHP code will be executed before the
  page is shown to the user and will not run after the page loads. JS and CSS handle the post*page load interactions
  like opening and closing dialogs.

  Forms are created by PHP/HTML and filled out by users. Forms have a "method" and an "action". The method is usually
  either post or get. Get will show the user entered data as a parameter in the URL while the POST will pass it as data
  silently. GET is used more for search forms while POST is used for user data. The action determines where the browser
  will go after submission. Most SciCrunch data forms will go to the /forms folder, where those scripts will handle the
  user data and push that data into the Database/perform actions and then tell the server to go somewhere to show the
  result.

  The /form scripts access a $_POST global variable that holds post data in a key:value array. The script will pull the
  data from that variable and pass that into the appropriate Class for what is being submitted and calls the classes
  Class::insertDB or Class::updateDB depending on what the action is. The class functions use the Connection class to
  talk to the Database if needed.

# External frameworks and libraries used:
  Unify is located in the directory assets.  All the other plugins are located in assets/plugins
* Unify
* jQuery v1.10.2
* jQuery plugins:
  * back-to-top v1.1 (http://www.dynamicdrive.com)
  * Backstretch v2.0.3 (http://srobbin.com/jquery-plugins/backstretch/)
  * BxSlider v4.0 (http://bxslider.com)
  * Countdown v1.6.2 (http://keith-wood.name/countdown.htm)
  * counterup v1.0 (http://gambit.ph)
  * Waypoints v2.0.4 (https://github.com/imakewebthings/jquery-waypoints)
  * Cube Portfolio v1.5.1 (http://scriptpie.com)
  * FlexSlider v2.0 (http://www.woothemes.com/flexslider/)
  * jQuery Steps v1.1.0 (http://www.jquery-steps.com)
  * jQuery UI v1.11.1 (http://jqueryui.com)
  * MIXITUP v1.5.4 (http://mixitup.io)
  * jQuery Parallax v1.1.3 (http://www.ianlunn.co.uk/plugins/jquery-parallax/)
  * Masonry v2.1.05 (http://masonry.desandro.com)
  * Revolution Slider v4.5.01 (http://codecanyon.net/item/slider-revolution-responsive-jquery-plugin/2580848)
  * Perfect Scrollbar (http://noraesae.github.io/perfect-scrollbar/)
  * jVectorMap v1.2.2 (http://jvectormap.com/)
* Bootstrap v3.2.0 (http://getbootstrap.com)
* circles.js v0.0.3 (https://github.com/lugolabs/circles)
* d3 v3.5.3 (http://d3js.org/) 
* fancyBox (http://www.fancyapps.com/fancybox/)
* Font Awesome 4.2.0 (http://fontawesome.io)
* Glyphicons Halflings (http://glyphicons.com/)
* GMaps v0.4.15 (http://hpneo.github.com/gmaps/)
* Sliding Horizontal Parallax v1.0 (http://www.sequencejs.com/themes/sliding-horizontal-parallax/)
* HTML5 Shiv 3.7.2 (https://github.com/afarkas/html5shiv)
* spin.js v1.3 (https://fgnass.github.com/spin.js#v1.3)
* LayerSlider v5.4.0 (http://kreaturamedia.com/)
* Modernizr v2.6.2 (http://modernizr.com/download/#-csstransforms-csstransitions-touch-shiv-cssclasses-prefixed-teststyles-testprop-testallprops-prefixes-domprefixes-load)
* OWL Carousel v1.31 (https://github.com/OwlFonk/OwlCarousel)
* HTML Purifier v4.6.0 (http://htmlpurifier.org/)
* Respond.js v1.1.0 (https://github.com/scottjehl/Respond)
* Sky-forms v2.0.1 (http://codecanyon.net/item/sky-forms-pro/5414510)
* Summernote v0.5.8 (http://hackerwins.github.io/summernote/)

  The following library should be in the css directory:
* joyride v2.0.3 (http://foundation.zurb.com)

  The following libraries should be in the js directory:
* jQuery Validation plugin v1.13.0 (http://jqueryvalidation.org/)
* Extended circle master (https://github.com/lugolabs/circles)
* jQuery joyride plugin v2.0.3 (http://foundation.zurb.com)
* jQuery truncate plugin (http://henrik.nyh.se)

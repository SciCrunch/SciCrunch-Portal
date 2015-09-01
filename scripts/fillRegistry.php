<?php

include '../classes/classes.php';
set_time_limit(120);


$translation = array(
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>0,
        "name"=>"Additional Resource Types",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The resource types this resource is categorized as"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>1,
        "name"=>"Listed By",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"Which communities list this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>2,
        "name"=>"Lists",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"Which communities this resource lists"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>3,
        "name"=>"Used By",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"Which communities/resources use this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>4,
        "name"=>"Uses",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"Which communities/resources are used by this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>5,
        "name"=>"Recommended By",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"Which communities recommend this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>6,
        "name"=>"Recommends",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"Which communities/resources this resource recommends"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>7,
        "name"=>"Availability",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"What is the current availability for this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>8,
        "name"=>"Terms Of Use URLs",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The location of the Terms of Use documentation for this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>9,
        "name"=>"Alternate URLs",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The alternate URLs you can use to reach this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>10,
        "name"=>"Old URLs",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The previous URLs that reached this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>11,
        "name"=>"Alternate IDs",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The alternate identifiers for this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>12,
        "name"=>"Relation",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The basic relationships for this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>13,
        "name"=>"Related Application",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"A comma separated list for applications related to this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>14,
        "name"=>"Related Disease",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"A comma separated list for diseases related to this resource"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>15,
        "name"=>"Located In",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>16,
        "name"=>"Processing",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>17,
        "name"=>"Species",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"The species that this resource is used on/for"
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>18,
        "name"=>"Supercategory",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>19,
        "name"=>"Publication Link",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>20,
        "name"=>"Resource PubMed IDs",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>0,"required"=>0,"position"=>10,
        "name"=>"Comment",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"",
        "curator"=>1
    ),
    array("uid"=>0,"cid"=>0,"tid"=>0,"required"=>0,"position"=>11,
        "name"=>"Editorial Note",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"",
        "curator"=>1
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>21,
        "name"=>"Resource Status",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>22,
        "name"=>"Website Status",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>0,"required"=>0,"position"=>12,
        "name"=>"Curation Status",
        "type"=>"text",
        "display"=>"text",
        "alt"=>"",
        "curator"=>1
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>23,
        "name"=>"Geo Location",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>24,
        "name"=>"Social URLs",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    ),
    array("uid"=>0,"cid"=>0,"tid"=>1,"required"=>0,"position"=>25,
        "name"=>"License",
        "type"=>"text",
        "display"=>"text",
        "alt"=>""
    )
);

foreach($translation as $array){
    $field = new Resource_Fields();
    $field->create($array);
    $field->insertDB();
}

?>
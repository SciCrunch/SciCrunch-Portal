<?php

$resource = new Resource();
$resource->getByRID($rid);

?>

<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left">Submission Successful</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/create/resource">Resource Type Select</a></li>
            <li class="active">Submission Successful</li>
        </ul>
    </div>
</div>
<!--=== End Breadcrumbs v3 ===-->
<div class="container first-container">
    <div class="alert alert-success fade in margin-bottom-40">
        <h4>Successfully Submitted the Resource</h4>
        <br/>
        <p>
            Your resource was given the identifier <b><?php echo $resource->rid?></b>, please use that in your citations.
        </p>
        <br/>
        <p>
            Thank you for your submission to the SciCrunch Resource Registry. Your resource was successfully collected
            and is undergoing curation. Newly submitted resources are normally added for community searches every
            Friday night. You will be alerted when your resource has been reviewed and approved with the approximate
            date that you can search for it in our registry.
        </p>
        <br/>
        <p>
            If you'd like to edit your resource before then or review your submission you can check out
            <a href="/account/resources/edit/<?php echo $resource->rid ?>">this resource</a> or <a href="/account/resources">all your submitted resource</a> in those links.
        </p>
    </div>
</div>
<?php
include '../classes/classes.php';

$name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);

$db = new Connection();
$db->connect();
$return = $db->select('resource_columns', array('distinct rid'), 's', array('%'.$name.'%'), 'where (name="Resource Name" or name="Synonyms" or name="Abbreviation") and value like ? limit 5');
$db->close();

if (count($return) > 0) {
    echo '<div class="alert alert-warning">';
    foreach ($return as $row) {
        $resource = new Resource();
        $resource->getByID($row['rid']);
        $resource->getColumns();
        ?>
        <div class="inner-results">
            <h3>
                <a href="/browse/resources/<?php echo $resource->rid ?>">
                    <?php echo $resource->columns['Resource Name']; ?>
                </a>
            </h3>

            <div class="overflow-h">
                <p>
                    <?php echo $resource->columns['Description']; ?>
                </p>
            </div>
        </div>
        <hr/>
    <?php
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-success">There was no resource similar in our system.</div>';
}
?>
<script>$('.inner-results p').truncate({max_length: 500});</script>
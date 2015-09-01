<?php

include '../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$view = filter_var($_GET['view'], FILTER_SANITIZE_STRING);

if (!isset($_SESSION['user']) || $_SESSION['user']->levels[$cid] < 2) {
    exit();
}

$snippet = new Snippet();
$snippet->getSnippetByView($cid, $view);
$snippet->resetter();
$snippet->splitParts();

$url = ENVIRONMENT . '/v1/federation/data/' . $view . '.xml?count=1&exportType=all';
$xml = simplexml_load_file($url);

?>
<div class="row" style="overflow: auto;height:100%;">
    <div class="col-md-2" style="overflow: auto;height:100%;">
        <div class="sky-form" style="overflow: auto;height:100%;">
            <header>Columns</header>
            <fieldset>
                <section>
                    <ul>
                        <?php
                        if ($xml) {
                            foreach ($xml->result->results->row->data as $data) {
                                echo '<li>' . $data->name . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </section>
            </fieldset>
        </div>
    </div>
    <div class="col-md-5" style="overflow: auto;height:100%;">
        <form method="post"
              action="/forms/community-forms/snippet-update.php?cid=<?php echo $cid ?>&view=<?php echo $view ?>"
              id="header-component-form" class="sky-form" style="overflow: auto;height:100%;"
              enctype="multipart/form-data">
            <header>Edit Snippet</header>
            <fieldset>
                <section>
                    <label class="label">Title</label>
                    <label class="input">
                        <i class="icon-prepend fa fa-asterisk"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" class="snippet-title" name="title"
                               placeholder="Focus to view the tooltip"
                               value="<?php echo strip_tags($snippet->snippet['title']) ?>" required>

                        <b class="tooltip tooltip-top-right">The title of the record shown in the resource view, will be
                            wrapped in a link and have all tags removed.</b>
                    </label>
                </section>
                <section>
                    <label class="label">Description</label>
                    <label class="textarea">
                        <i class="icon-prepend fa fa-asterisk"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <textarea class="snippet-description" rows="6" name="description"
                                  placeholder="Focus to view the tooltip"><?php echo $snippet->snippet['description'] ?></textarea>
                        <b class="tooltip tooltip-top-right">The descriptive text about each record.</b>
                    </label>
                </section>
                <section>
                    <label class="label">URL</label>
                    <label class="input">
                        <i class="icon-prepend fa fa-asterisk"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" class="snippet-url" name="url" placeholder="Focus to view the tooltip"
                               value="<?php echo strip_tags($snippet->snippet['url']) ?>">
                        <b class="tooltip tooltip-top-right">The column that contains the url for this record to go to
                            the resource.</b>
                    </label>
                </section>
                <section>
                    <label class="label">Cite This</label>
                    <label class="input">
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" name="citation" placeholder="Focus to view the tooltip"
                               value="<?php echo strip_tags($snippet->snippet['citation']) ?>">
                        <b class="tooltip tooltip-top-right">Only fill out if you want a cite this button to appear for
                            these records.</b>
                    </label>
                </section>
            </fieldset>
            <footer>
                <button class="test-snippet btn-u" type="button">Test</button>
                <button type="submit" class="btn-u btn-u-default">Submit</button>
            </footer>
        </form>
    </div>
    <div class="col-md-5" style="overflow: auto;height:100%;">
        <div class="sky-form" style="overflow: auto;height:100%;">
            <header>Testing</header>
            <fieldset>
                <section class="testing-zone">
                </section>
            </fieldset>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.test-snippet').click(function () {
            $('.testing-zone').load(
                '/php/snippet-test.php?view=<?php echo $view?>&title=' + encodeURIComponent($('.snippet-title').val())
                    + '&desc=' + encodeURIComponent($('.snippet-description').val()) + '&url=' + encodeURIComponent($('.snippet-url').val())
            );
        });
    });
</script>
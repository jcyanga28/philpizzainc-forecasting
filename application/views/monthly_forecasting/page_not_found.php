<div id="page_not_found_container">

    <div style="width: 95%; color: #333;">

        <div style="margin-left: 25px;">

            <h2>Sorry, this page isn't available</h2>
            <p class="lead">The link you followed may be broken, or the page may have been removed, or you may not have permission to view this page.</p>
            <hr/>

            <?php
            $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            $pageURL .= $_SERVER["SERVER_NAME"];
            ?>

            <a href="<?php  echo $pageURL;?>">
            <button type="button" class="btn btn-default" style="font-size: 12px;font-weight:bold;background-color:#333;border:0;color:#fff;"><span class="glyphicon glyphicon-home"></span>&nbsp;<b>Back to Home Page</b></button> 
            </a>

        </div>
        <br/>

    </div>

</div>

<?php echo br(2); ?>
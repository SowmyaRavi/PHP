<?php

//Home page for producers

//Includes configaration files
require ('../includes/config-inc.php');

//Set page title and include html header
$page_title='Producer Home page';
include (HEADER);
?>
    <div class="jumbotron">
        
        <?php 
            redirect_ifNotLoggedIn();
            echo '<h2><b>Welcome Producer';
            if (isset($_SESSION['first_name'])) {
                echo ", {$_SESSION['first_name']}";
            }
            echo '!</b></h2>';
        ?>        
    </div>
<?php
echo '<h3>Producer\'s Benefits:</h3><p class="text-info"> You Can Publish artwork\'s
by first moving from producer list to publish page. Once artwork added to producer list you have all
the rights to publish,set price,edit contents.</br>
You can also view all artwork\'s both published and unpublished.</p>';
include(FOOTER);

?>
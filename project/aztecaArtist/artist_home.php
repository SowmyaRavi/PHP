<?php
    //Home Page for Authors

    // Include the configuration file:
    require ('../includes/config-inc.php');

    //include the HTML header:
    include (HEADER);
    ?>
        <div class="jumbotron">
            
            <?php 
                redirect_ifNotLoggedIn();
                echo '<h2><b>Welcome Artist';
                if (isset($_SESSION['first_name'])) {
                    echo ", {$_SESSION['first_name']}";
                }
                echo "!</b></h2>";
            ?>        
        </div>
    <?php
        echo '<h3>Artist Benefits:</h3><p class="text-info"> You Can Add New Artwork in Add new Artwork page.</br>
                You can view all the artwork\'s you have submitted in  Manage Artist Artwork</br>
                You can also view all artwork both published and unpublished. But cant edit or delete price of them.</p>';

                include(FOOTER);
?>           
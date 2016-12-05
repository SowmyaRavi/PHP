
<?php
// This script allows producers to process image files.
require ('../includes/config-inc.php');
include (HEADER);
require_once (FUN_DEFS);
require (PDO);

redirect_ifNotLoggedIn();
function show_images($orginal_name){
    $original_path = "../../tmpmedia/original/".$orginal_name.".jpg";
    $thumbnail_path =  "../../tmpmedia/thumbnail/".$orginal_name.".thumbnail.jpg";
    $teaser_path =  "../../tmpmedia/teaser/".$orginal_name.".teaser.jpg";
    $cover_path =  "../../tmpmedia/cover/".$orginal_name.".cover.jpg";
    
    if(file_exists($original_path)){
        echo('<div><h3>original Image :</h3><img src='.$original_path.'></div>');
    }
    if(file_exists($thumbnail_path)){
        echo('<div><h3>Thumbnail Image :</h3><img src='.$thumbnail_path.'></div>');
    }
    if(file_exists($teaser_path)){
        echo('<div><h3>Teaser Image :</h3><img src='.$teaser_path.'></div>');
    }
    if(file_exists($cover_path)){
        echo('<div><h3>Cover Image :</h3><img src='.$cover_path.'></div>');
    }
}

if(isset($_GET['a_id'])){
    $orginal_name = $_GET['a_id'];
}else{
    $orginal_name = "";
}

echo '<h1>Process Images of Artwork</h1>
<div class ="btn-group">
    <a href="process_image.php?mode=show&a_id='.$orginal_name.'"><button type="button" class ="btn btn-primary">Show Images</button></a>
    <a href="process_image.php?mode=upload&a_id='.$orginal_name.'"><button type="button" class ="btn btn-primary">Upload new</button></a>
    <a href="process_image.php?mode=thumb&a_id='.$orginal_name.'"><button type="button" class ="btn btn-primary">Create Thumbnail</button></a>
    <a href="process_image.php?mode=teaser&a_id='.$orginal_name.'"><button type="button" class ="btn btn-primary">Create teaser</button></a>
    <a href="process_image.php?mode=cover&a_id='.$orginal_name.'"><button type="button" class ="btn btn-primary">Create Cover Page</button></a>
</div>';
    
if(isset($_GET['mode'])&& $orginal_name){
    $art_title = get_art_detail($dbh,"art_title",$orginal_name);
    $artist_name = get_art_detail($dbh,"artist_name",$orginal_name);
    $_producer = get_art_detail($dbh,"producer_name",$orginal_name);
    $original_path = "../../tmpmedia/original/".$orginal_name.".jpg";
    $file_name = $orginal_name;

    if(file_exists($original_path)){
         $file_name1 = $orginal_name;
    }else{
        $file_name1= "";
    }
   
    echo("<hr><div>");
    switch ($_GET['mode']) {
        case 'show':
            show_images($orginal_name);
                
            break;
        case 'upload':
            echo('<form action="../aztecaPython/upload_handler.py" method="post" enctype="multipart/form-data">
                <div class="checkbox">
                  <label><input type="checkbox" name="optcheck" value="1">Read GPS EXIF Data if any</label>
                </div>

                <div class="radio">
                  <label><input type="radio" name="optradio" value="1">Apply Embossing</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="optradio" value="2">Apply Edge Detection</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="optradio" value="3">Apply Blur</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="optradio" value="4">None</label>
                </div>
                <div class="btn-group inline pull-left">

                        <div class="btn btn-sm"><input type="file" name="fileToUpload" id="fileToUpload"></div>
                        <div class="btn btn-md"><input type="submit" class="btn btn-primary" value="Upload Image" name="submit"></div>'.
                    '<input type="hidden" name="file_name" value="'. $file_name .'"/></form></div>');

            break;
        case 'thumb':
            echo('<form action="../aztecaPython/thumb_handler.py" method="post">' .
            '<b>Create Thumbnail of uploaded image:</b></br><input type="submit" value="Create/Show Thumbnail"><hr>' .
            '<input type="hidden" name="fileToThumb" value="'. $file_name1 .'"/></form>');

            break;
        case 'teaser':
            echo('<form action="../aztecaPython/teaser_handler.py" method="post">' .
            '<b>Enter line 1(eg: a quote on the top): </b><div><TextArea name="teaser_text1" cols = "40" rows = "2">Artzteca Studios Presents...</TextArea></div>'.
            '<b>Enter line 2 (eg: Title of the artwork): </b><div><TextArea name="teaser_text2" cols = "40" rows = "2">'.$art_title.'</TextArea></div>'.
            '<b>Enter line 3 (eg: Artist Name): </b><div><TextArea name="teaser_text3" cols = "40" rows = "2">'.$artist_name.'</TextArea></div>'.
            '<b>Add Watermarking text(eg: copyright): </b><div><TextArea name="teaser_text_c" cols = "40" rows = "2">&copy ASC Inc</TextArea></div>'.
            
            '</br><input type="submit" value = "Create/Show Teaser"><hr>' .
            '<input type="hidden" name="fileToTeaser" value="'. $file_name1.'"/></form>');

            break;
        case 'cover':
             echo('<form action="../aztecaPython/cover_handler.py" method="post">' .
            '<b>Enter line 1(eg: a quote on the top): </b><div><TextArea name="cover_text_f1" cols = "40" rows = "2">Artzteca Studios Presents...</TextArea></div>'.
            '<b>Enter text on front line2(eg: Artist name): </b><div><TextArea name="cover_text_f2" cols = "40" rows = "2">'.$artist_name.'</TextArea></div>'.
            '<b>Enter line on spine (eg: Title of the artwork): </b><div><TextArea name="cover_text_s" cols = "40" rows = "2">'.$art_title.'</TextArea></div>'.
            '<b>Enter line on back (eg: producer name): </b><div><TextArea name="cover_text_b" cols = "40" rows = "2">'.$_producer.'</TextArea></div>'.
            '</br><input type="submit" value = "create/show  artwork cover"><hr>' .
            '<input type="hidden" name="fileToCover" value="'. $file_name1 .'"/></form>');

            break;

        default:
             
            break;
    }
    echo("</div>");
}


include (FOOTER);
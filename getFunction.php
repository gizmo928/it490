<?php  $titles = array();
        $releaseDates = array();
        $genres = arraY();
        $pics = array();
        $purchLinks = array();
        $db = mysqli_connect('localhost','root','root','example');
        mysqli_select_db($db, 'example');
        $s = "select * from movie";
        $t = mysqli_query($db,$s) or die (mysqli_error($db));
        while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
        {
          array_push($titles, $r["title"]);
          array_push($releaseDates, $r["releaseDate"]);
          array_push($genres, $r["genre"]);
          array_push($pics, $r["photo"]);
          array_push($purchLinks, $r["link"]);
        }


?>
<script type="text/javascript">
var titles  = '<?php echo json_encode($titles);   ?>';
var releaseDates  = '<?php echo json_encode($releaseDates);   ?>';
var genres = '<?php echo json_encode($genres);  ?>';
var pics  = '<?php echo json_encode($pics);   ?>';
var purchLinks  = '<?php echo json_encode($purchLinks);   ?>';

</script>
<script type= "text/javascript" src = "ajax_test.html"></script>


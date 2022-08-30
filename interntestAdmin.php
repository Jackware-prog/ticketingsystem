<!DOCTYPE html>
<?php
$hostname = "localhost";
$username = "root";
$port = "";
$database = "ticketdatabase";

$connection = new mysqli($hostname,$username,$port,$database);

if(!$connection){
    die();
}
?>
<html>
    <head>
        <link rel="stylesheet" href="interntest.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <section class="A-title">
            <p>Counter Management</p>
        </section>
        
        <section class="counter">
            <?php
            $allcounterquery = "SELECT * FROM `counter`";
            $allcounter = $connection -> query($allcounterquery);
            while($eachcounter = mysqli_fetch_array($allcounter)){
            if($eachcounter['counter_status'] == "off"){
                $counterstat = "makeon";
                $goonline = "Go Online";
            }else{
                $counterstat = "makeoff";
                $goonline = "Go Offline";
            }

            print_r('<div class="eachcounter">
                    <form method="post">
                        <input type="hidden" name="counter" value = "'.$eachcounter["counter"].'">
                        <div class="EC-title">'.$eachcounter["counter"].'</div>
                        <div class="adminbtn-wrap '.$counterstat.'">
                            <button type="submit" name="onoffcounter">'.$goonline.'</button>
                            <button type="submit" name="completecurr">Comp curr</button>
                            <button type="submit" name="nextnumber">Call Next</button>
                        </div> 
                    </form> 
                    </div>
                </div>');
            }
            ?>
        </section>
    </body>
<?php

    // Call Next BUTTON
    if(isset($_POST['nextnumber'])){
        $nowservingnumquery = "SELECT NUM FROM ticket WHERE NUM_status ='pending' ORDER BY NUM asc LIMIT 1";
        $previousservingnumquery = "SELECT NUM FROM ticket WHERE (NUM_status ='serving' AND `counter`='".$_POST['counter']."') ORDER BY NUM asc LIMIT 1";
        $donepreviousnum = $connection -> query($previousservingnumquery);
        if(mysqli_num_rows($donepreviousnum) == 1){
            $thepreviousnum = mysqli_fetch_array($donepreviousnum);
            $donenumquery = "UPDATE ticket SET NUM_status = 'complete' WHERE NUM = '".$thepreviousnum['NUM']."'";
            $connection -> query($donenumquery);
        }

        $nowservingnum = $connection->query($nowservingnumquery);
        $theservingnum = mysqli_fetch_array($nowservingnum);
        $counterbusy = "UPDATE `counter` SET counter_status = 'busy' WHERE `counter`='".$_POST['counter']."'";


        $callnextquery = "UPDATE ticket SET NUM_status = 'serving',`counter`='".$_POST['counter']."' WHERE NUM = '".$theservingnum['NUM']."'";
        if(($connection -> query($callnextquery)) and ($connection -> query($counterbusy))){
            echo "<script> alert('Next Number is called to ".$_POST['counter']."')</script>";
            echo "<script>
                        window.history.replaceState( null, null, window.location.href );
                </script>";
        }else{
            echo "<script> alert('Something when wrong, Please Try Again!')</script>";
            echo "<script>
                        window.history.replaceState( null, null, window.location.href );
                </script>";
        }
    }

    // Complete Curr BTN
    if(isset($_POST['completecurr'])){
        $previousservingnumquery = "SELECT NUM FROM ticket WHERE (NUM_status ='serving' AND `counter`='".$_POST['counter']."') ORDER BY NUM asc LIMIT 1";
        $donepreviousnum = $connection -> query($previousservingnumquery);
        if(mysqli_num_rows($donepreviousnum) == 1){
            $thepreviousnum = mysqli_fetch_array($donepreviousnum);
            $donenumquery = "UPDATE ticket SET NUM_status = 'complete' WHERE NUM = '".$thepreviousnum['NUM']."'";
            $counteron = "UPDATE `counter` SET counter_status = 'on' WHERE `counter`='".$_POST['counter']."'";

            if (($connection -> query($counteron)) and ($connection -> query($donenumquery))){
                echo "<script> alert(' ".$_POST['counter']." is now available')</script>";
                echo "<script>
                            window.history.replaceState( null, null, window.location.href );
                    </script>";
            }else{
                echo "<script> alert('Something when wrong, Please Try Again!')</script>";
                echo "<script>
                            window.history.replaceState( null, null, window.location.href );
                    </script>";
            }
        }else{
            echo "<script> alert(' ".$_POST['counter']." is already available')</script>";
            echo "<script>
                        window.history.replaceState( null, null, window.location.href );
                </script>";
        }
    }

    // Go Off or Online Button
    if(isset($_POST['onoffcounter'])){
        $thecounterstatquery = "SELECT counter_status FROM `counter` WHERE `counter`= '".$_POST['counter']."'";
        $thecounterstat = $connection -> query($thecounterstatquery);
        $counterstat = mysqli_fetch_array($thecounterstat);

        if($counterstat['counter_status'] == "on"){
            $counteroff = "UPDATE `counter` SET counter_status = 'off' WHERE `counter`='".$_POST['counter']."'";
            $connection -> query($counteroff);
            echo "<script> alert(' ".$_POST['counter']." go offline.')</script>";
            echo "<script>
                        window.history.replaceState( null, null, window.location.href );
                </script>";
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=\"interntestAdmin.php\">";

        }else if($counterstat['counter_status'] == "off"){
            $counteron = "UPDATE `counter` SET counter_status = 'on' WHERE `counter`='".$_POST['counter']."'";
            $connection -> query($counteron);
            echo "<script> alert(' ".$_POST['counter']." go online.')</script>";
            echo "<script>
                        window.history.replaceState( null, null, window.location.href );
                </script>";
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=\"interntestAdmin.php\">";
        }else if($counterstat['counter_status'] == "busy"){
            echo "<script> alert(' ".$_POST['counter']." is still busy')</script>";
            echo "<script>
                        window.history.replaceState( null, null, window.location.href );
                </script>";
        }
    }

?>
</html>

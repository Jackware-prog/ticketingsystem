<!DOCTYPE html>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ticketdatabase";

$connection = new mysqli($hostname,$username,$password,$database);

if(!$connection){
    die();
}
?>
<html>
    <head>
        <link rel="stylesheet" href="interntest.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <?php
    //  Take A NUMBER
    if(isset($_POST['takenum'])){
        $takenum = "INSERT INTO ticket (`NUM_status`, `counter`) VALUES('pending',null)";
        if($connection -> query($takenum)){
            $newestnumquery = "SELECT NUM FROM ticket ORDER BY NUM desc";
            $newestnum = $connection -> query($newestnumquery);
            $fetchnum = mysqli_fetch_array($newestnum);
            echo "<script> alert('Your Number is ".$fetchnum['NUM']."')</script>";
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


    ?>
    <body>
        <form method="post">
            <section class="gettic">
                <div class="gettic-box">
                    <div class="box-wrap">
                    <?php
                        // Display now serving and last number
                        $nowservingnumquery = "SELECT NUM FROM ticket WHERE NUM_status ='pending' ORDER BY NUM asc LIMIT 1";
                        $nowservingnum = $connection->query($nowservingnumquery);
                        $lastnumquery = "SELECT NUM FROM ticket ORDER BY NUM desc LIMIT 1";
                        $lastnum = $connection->query($lastnumquery);
                        if((mysqli_num_rows($lastnum) != 0)and(mysqli_num_rows($nowservingnum) != 0)){
                            if(($num1 = mysqli_fetch_array($nowservingnum)) and ($num2 = mysqli_fetch_array($lastnum))){
                                print_r('<div>Now Serving:</div><div>'.$num1["NUM"].'</div>
                                        <div>Last Number:</div><div>'.$num2["NUM"].'</div>');
                            }
                        }else{
                            print_r('<div>Now Serving:</div><div>-</div>
                                    <div>Last Number:</div><div>-</div>');
                        }
                    ?>
                    </div>    
                    <div class="wrap-btn"><button type="submit" name="takenum">Take a Number</button></div>
                </div>
            </section>
        </form>
        <section class="gettic2">
            <?php
            // Display Counter


            $allcounterquery = "SELECT * FROM counter";
            $allcounter = $connection -> query($allcounterquery);
            if(mysqli_num_rows($allcounter) > 0){
                while($eachcounter = mysqli_fetch_array($allcounter)){
                    $ticketservingquery = "SELECT * FROM ticket WHERE (NUM_status = 'serving' AND `counter` = '".$eachcounter['counter']."')";
                    $ticketserving = $connection -> query($ticketservingquery);
                    if(mysqli_num_rows($ticketserving) == 1){
                        $theticketserving = mysqli_fetch_array($ticketserving);
                        $serve_num = $theticketserving['NUM'];
                    }else if($eachcounter['counter_status'] === "off"){
                        $serve_num = "Offline";
                    }else{
                        $serve_num = "";
                    }

                    print_r('<div class="gettic2-box '.$eachcounter["counter_status"].'">
                                <div class="blub-wrap"><div class="bulb"></div></div>
                                <div class="counter"> '.$eachcounter["counter"].' </div>
                                <div class="serve-num">'.$serve_num.'</div>
                            </div>');
                }
            }
            ?>
        </section>
    </body>
    <meta http-equiv="refresh" content="5" />
</html>
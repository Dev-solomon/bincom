<?php
include ('conn_db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <title>NEW PU</title>
</head>
<body>
    <h1 class="text-center mt-2">REGISTER A NEW POLLING_UNIT</h1>
    <!-- For Registering a New Polling Unit -->
    <div class="container mt-5">
        <form action="" method="post" class="container d-flex flex-row justify-content-evenly">
            <div class="d-flex flex-column">
                <p class="text-center">Polling_unit_ID</p>
                <input name="pu_id" id="" value="">
                <span style="font-size: 10px; color:red;" class="text-center" id="pu_id"></span>
            </div>
            <div class="d-flex flex-column">
                <p class="text-center">Ward_ID</p>
                <input name="w_id" id="" value="">
                <span style="font-size: 10px; color:red;" class="text-center" id="w_id"></span>
            </div>
            
            <div class="d-flex flex-column">
                <p class="text-center">Polling_unit_name</p>
                <input name="pu_name" id="" value="">
                <span style="font-size: 10px; color:red;" class="text-center" id="pu_name"></span>
            </div>
            <div class="d-flex flex-column">
                <p class="text-center">Polling_unit_Number</p>
                <input name="pu_num" id="" value="">
                <span style="font-size: 10px; color:red;" class="text-center" id="pu_num"></span>
            </div>
             
      
           <style>
             select#selectlga{
                            outline-style: none;
                            color: white; 
                            border: none;
                            border-radius: 10px;
                            font-size: 10px;
                            background-color: blue; 
                            width: fit-content;
                            height: fit-content;
                            margin-top: auto;
                            margin-bottom: 5px;

                        }
                        button#sub{
                            outline-style: none;
                            color: white; 
                            border: none;
                            border-radius: 10px;
                            font-size: 10px;
                            background-color: green; 
                            width: fit-content;
                            height: fit-content;
                            /* margin-top: 5px;
                            margin-bottom: auto;
                            margin-right: auto;
                            margin-left: 5px; */
                            margin: auto;
                        }
           </style>
           
            <?php
                // Query structure for displaying all the LGAs into the the selection TAG
                $sql = "SELECT  lga_name,lga_id FROM lga";
                $query = $conn->prepare($sql);
                
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ); 
                ?>
                 <section class="d-flex flex-column">

                
                    <select name="opt_lg" id="selectlga">
                        <option value="" style="background-color:gray">CHOOSE LGA</option> 
                        <!-- List all the LGA into the options under the select -->
                        <?php
                        if($query->rowCount() > 0) {
                            foreach ($results as $result) {
                        ?>
                            <option value="<?php echo $result->lga_id ?>" style="background-color:green;"> <?php echo $result->lga_name;  } }  ?>
                            </option>
                            
                    </select>
                    <span style="font-size: 10px; color:red;" class="text-center" id="opt_lg"></span>
                   
                     <!-- Submit button for the LGA chosen! -->
                     <!-- <button type="submit" name="submit" id="sub">Submit</button> -->
                    
                 
                <button type="submit" name="submit" id="sub">REGISTER</button>
                </section>
                </form>
        </div>

        <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['pu_id'])){
                    $pu_id = $_POST['pu_id'];
                }else{ echo "<script>document.getElementById('pu_id').innerText = 'Input A Valid Unit ID';</script>";
                return; }

                if(!empty($_POST['w_id'])){
                    $w_id = $_POST['w_id'];
                }else{echo "<script>document.getElementById('w_id').innerText = 'Input A Valid Ward ID';</script>"; 
                return; }

                if(!empty($_POST['pu_name'])){
                    $pu_name = $_POST['pu_name'];
                }else{ echo "<script>document.getElementById('pu_name').innerText = 'Input A Valid Unit name';</script>";
                    return;}

                if(!empty($_POST['pu_num'])){
                    $pu_num = $_POST['pu_num'];
                }else{ echo "<script>document.getElementById('pu_num').innerText = 'Input A Valid Unit Number';</script>";
                    return;}

                if(!empty($_POST['opt_lg'])){
                    $opt_lg = $_POST['opt_lg'];
                    
                }else{echo "<script>document.getElementById('opt_lg').innerText = 'Choose one LGA';</script>"; 
                    return;}
                    
                    $sql = "INSERT INTO `polling_unit` (`polling_unit_id`, `ward_id`, `lga_id`, `uniquewardid`, `polling_unit_number`, `polling_unit_name`, `polling_unit_description`, `lat`, `long`, `entered_by_user`, `date_entered`, `user_ip_address`) VALUES 
                    ($pu_id, $w_id, $opt_lg, NULL, '$pu_num', '$pu_name', '$pu_name', NULL, NULL, NULL, NULL, NULL)";
                        
                     $query = $conn->query($sql);
                     $success = $conn->lastInsertId();

                     if($success){
                        echo "<script> alert('New Polling_unit Has Been Registered');</script>";
                     } else{
                        echo "<script> alert(Something Went Wrong! TRY AGAIN...');</script>";
                     }

            }

        ?>
   
   <!-- THIS IS THE CONTAINER FOR STORING A NEW POLLING UNIT SCORE -->
   <h2 class="text-center mt-5">RECORD POLLING_UNIT SCORE HERE FOR _PARTIES!</h2>
   <div class="container mt-5">
        <form action="" method="post" class="container d-flex flex-row justify-content-evenly">
            <div class="d-flex flex-column">
                <p class="text-center">Party Name</p>
                <input name="p_name" id="" value="">
                <span style="font-size: 10px; color:red;" class="text-center" id="p_name"></span>
            </div>
            <div class="d-flex flex-column">
                <p class="text-center">Your Party Score</p>
                <input name="p_score" id="" value="">
                <span style="font-size: 10px; color:red;" class="text-center" id="p_score"></span>
            </div>
            

             
      
           <style>
             select#selectlga{
                            outline-style: none;
                            color: white; 
                            border: none;
                            border-radius: 10px;
                            font-size: 10px;
                            background-color: blue; 
                            width: fit-content;
                            height: fit-content;
                            margin-top: auto;
                            margin-bottom: 5px;

                        }
                        button#sub{
                            outline-style: none;
                            color: white; 
                            border: none;
                            border-radius: 10px;
                            font-size: 10px;
                            background-color: green; 
                            width: fit-content;
                            height: fit-content;
                            /* margin-top: 5px;
                            margin-bottom: auto;
                            margin-right: auto;
                            margin-left: 5px; */
                            margin: auto;
                        }
           </style>
           
            <?php
                // Query structure for displaying all the LGAs into the the selection TAG
                $sql = "SELECT  uniqueid,polling_unit_name FROM polling_unit GROUP BY polling_unit_name";
                $query = $conn->prepare($sql);
                
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ); 
                ?>
                 <section class="d-flex flex-column">

                
                    <select name="opt_lg1" id="selectlga">
                        <option value="" style="background-color:gray">CHOOSE POLLING_UNIT</option> 
                        <!-- List all the LGA into the options under the select -->
                        <?php
                        if($query->rowCount() > 0) {
                            foreach ($results as $result) {
                        ?>
                            <option value="<?php echo $result->uniqueid ?>" style="background-color:green;"> <?php echo $result->polling_unit_name;  } }  ?>
                            </option>
                            
                    </select>
                    <span style="font-size: 10px; color:red;" class="text-center" id="opt_lg1"></span>
                   
                     <!-- Submit button for the LGA chosen! -->
                     <!-- <button type="submit" name="submit" id="sub">Submit</button> -->
                    
                 
                <button type="submit" name="submit_record" id="sub">Submit Records</button>
                </section>
                </form>
        </div>

        <?php
            if(isset($_POST['submit_record'])){
                if(!empty($_POST['p_name'])){
                    $p_name = $_POST['p_name'];
                }else{ echo "<script>document.getElementById('p_name').innerText = 'Input A Valid Party Name';</script>";
                return; }

                if(!empty($_POST['p_score'])){
                    $p_score = $_POST['p_score'];
                }else{echo "<script>document.getElementById('p_score').innerText = 'Input A Valid Party Score';</script>"; 
                return; }

                if(!empty($_POST['opt_lg1'])){
                    $opt_lg = $_POST['opt_lg1'];
                }else{echo "<script>document.getElementById('opt_lg1').innerText = 'Choose a Polling_unit';</script>"; 
                return; }
                    $date =date('Y-m-d H:i:s');
                    $addr = getenv('REMOTE_ADDR');
                $sql = "INSERT INTO `announced_pu_results`(`polling_unit_uniqueid`, `party_abbreviation`, `party_score`, `entered_by_user`, `date_entered`, `user_ip_address`) VALUES
                ('$opt_lg', '$p_name', $p_score, 'Admin', '$date', '$addr')";
                    
                 $query = $conn->query($sql);
                 $success = $conn->lastInsertId();

                 if($success){
                    echo "<script> alert('NEW PARTY RECORD SUCCESSFUL');</script>";
                 } else{
                    echo "<script> alert(Something Went Wrong! TRY AGAIN...');</script>";
                 }

            }

        ?>
   


   
    
</body>
</html>
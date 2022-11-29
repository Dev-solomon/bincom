<?php
// Connection to the database
include ('conn_db.php');
?>
<!-- The Document Display page for the Test -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BINCOM - ONLINE INTERVIEW TEST</title>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Heading of the page -->
    <p class="text-center m-4 fs-4"><u>BINCOM - PRELIMINARY ONLINE INTERVIEW TEST</u>  <br> </p>
    <!-- Selection buttons for different Functions -->
    <div class="d-flex flex-row justify-content-center">
    <button id="a"><a href="new_unit.php">NEW POLLING UNIT</a></button>
        <!-- Display the results for each polling unit and a specific party -->
    <button id="pu" onclick="pu_Func()">View Polling_Units_results</button>
    <!-- Display the results for the summed total results for all the polling units under any LGA -->
    <button id="lg" onclick="lg_Func()">View LGA_results</button> 
   
    <!-- CSS styling for each of the buttons -->
                    <style>
                        button#pu,button#lg{
                            outline-style: none;
                            color: white; 
                            border: none;
                            /* padding: 2px; */
                            background-color: grey;
                            margin-left: 5px;
                            margin-right: 5px;
                            border-radius: 10px;
                            font-size: 20px;
                        } 
                        select#selectlga,button#sub{
                            outline-style: none;
                            color: white; 
                            border: none;
                            border-radius: 10px;
                            font-size: 20px;
                            background-color: blue; 

                        }
                        button#a{
                            /* outline: none; */
                            border: none; 
                        }
                        a{
                            text-decoration: none;
                            color: red; 
                        }
                    </style>

                <?php
                // Query structure for displaying all the LGAs into the the selection TAG
                $sql = "SELECT  lga_name FROM lga";
                $query = $conn->prepare($sql);
                
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ); 
                ?>

                
                  <!-- Form for handling the LGA selection tag -->
                <form method="post" action="">
                    <select name="opt_lg" id="selectlga">
                        <option value="" style="background-color:gray">SELECT LGA</option> 
                        <!-- List all the LGA into the options under the select -->
                        <?php
                        if($query->rowCount() > 0) {
                            foreach ($results as $result) {
                        ?>
                            <option value="<?php echo $result->lga_name ?>" style="background-color:green;"> <?php echo $result->lga_name;  } }  ?>
                            </option>
                    </select>
                    <!-- Submit button for the LGA chosen! -->
                    <button type="submit" name="submit" id="sub">Submit</button>
                </form>
    </div>
            <?php 
            // Query for handling the submit button
            if(isset( $_POST['submit'])){
                if(!empty($_POST['opt_lg'])){
                    $opt_lg = $_POST['opt_lg'];
                     
                    $sql = "SELECT lga_name,SUM(party_score) AS `party_score`  FROM 
                    lga LEFT JOIN polling_unit  ON polling_unit.lga_id = lga.lga_id
                        LEFT JOIN announced_pu_results ON announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid WHERE lga_name = :s";
                    $query = $conn->prepare($sql);
                    $query -> bindParam(':s',$opt_lg,PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
                    if($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            // ternary operator for checking if the total result has a score or not
                            ($result->party_score == NULL) ? $result->party_score = 0 : $result->party_score ;
                    echo   //Display the result for each lga summed total in a table
                    " 
                    <div class='container' style='display:block;' id='single_lga'>
                    <table class='table'> 
                    <thead class='thead-dark'>
                    <tr>
                        <td class='text-center'>LGA_NAME</td>
                        <td class='text-center'>LGA_TOTAL</td>
                    </tr>
                    </thead>
                        <tbody>
                            
                            <tr>
                                <td class='text-center'>$result->lga_name</td>
                            <td class='text-center'>$result->party_score </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <script> 
                    document.getElementById('single_lga').style.display = 'block'; 
                    </script> ";
                }
            }  
                
                }
                    

            }
            ?>
                  
                
               
   
    
  

<!-- ######################### This is the Div for the table of POLLING UNIT calculations ############ -->
    <div class="container text-center mt-5" id="divpu" style="display: none;">
        <table class="table table-dark">
            <thead class="thead-light">
                 <tr colspan="4">
                    <th class="text-center text-success">POLLING_UNIT_NAMES</th>
                    <th class="text-center text-success">POLLING_UNIT_TOTAL_RESULTS</th>
                    <th class="text-center text-success">_PARTIES</th>
                </tr>
            </thead>
            <?php  
                $sql = "SELECT polling_unit_name,party_abbreviation,party_score AS `total_score` FROM 
                polling_unit JOIN announced_pu_results ON polling_unit.uniqueid = announced_pu_results.polling_unit_uniqueid
                ";
                $query = $conn->prepare($sql);
                // $query -> bindParam(':s',$s,PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if($query->rowCount() > 0) {
                    foreach ($results as $result) {
            ?>

                    <!-- Display results for each polling unit and each party contested -->
            <tbody> 
                <tr></tr>
                <tr> 
                    <td><?php echo htmlentities($result->polling_unit_name) ?></td>
                    <td><?php echo htmlentities($result->total_score) ?></td>
                    <td><?php echo htmlentities($result->party_abbreviation) ?></td> 
                </tr>
            </tbody>

            <?php
                    }
                }
            ?> 
          
           <tfoot>
                <tr>
                 <th></th>
                 <th></th>
                    <th class="text-end text-info" style="font-size:10px;">fasoprogramming@gmail.com test solutions</th>
                </tr>
            </tfoot>
            
        </table>
    </div>



    <!-- ######################### This is the Div for the table of LGA calculations ############ -->
    <div class="container text-center mt-5" id="divlg" style="display: none;">
        <table class="table table-dark">
            <thead class="thead-light">
                 <tr colspan="4">
                    <th class="text-center text-success">LGA_NAMES</th>
                    <th class="text-center text-success">LGA_TOTAL_RESULTS</th>
                </tr>
            </thead>
            <?php  
                $sql = "SELECT lga_name,SUM(party_score) AS `party_score`  FROM 
                lga LEFT JOIN polling_unit  ON polling_unit.lga_id = lga.lga_id
                 LEFT JOIN announced_pu_results ON announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid GROUP BY lga_name";
                $query = $conn->prepare($sql);  
                $query->execute(); 
                $results = $query->fetchAll(PDO::FETCH_OBJ); 

                if($query->rowCount() >= 0) {
                    foreach ($results as $result) {
                        ($result->party_score == NULL) ? $result->party_score = 0 : $result->party_score ;
                        ?>


            <tbody> 
                <tr>
                    <td><?php echo htmlentities($result->lga_name) ?></td>  
                    <td><?php echo htmlentities($result->party_score)?></td>   
                </tr>                 
            </tbody>
       
       <?php
                        
            }
        }
        ?>
         
           <tfoot>
                <tr> 
                   <th></th>
                    <th class="text-end text-info" style="font-size:10px;">fasoprogramming@gmail.com test solutions</th>
               </tr>
            </tfoot>
            
        </table>
    </div>

    
    <script src="main.js"></script> <!--javascript file for the Index page -->
    <script src="bootstrap-5.1.3-dist/jquery.js"></script>
    <script src="bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
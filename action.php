<?php 

//action.php
include('database_connection.php');


if(isset($_POST["action"])){


    //insert new data to mysql
    if($_POST["action"] == "insert"){
        $query = "
            INSERT INTO tbl_sample (first_name, last_name) 
            VALUES ('".$_POST["first_name"]."', '".$_POST["last_name"]."')
        ";

        $statement = $connect -> prepare($query);
        $statement -> execute(); //sorgu yapılıyor mysql'e
        echo '<p> Data Inserted... </p>'; //ajaxa geri gönderilen veri
    }


    //fetch single data from mysql
    if($_POST["action"] == "fetch_single"){
        $query = "
            SELECT * 
            FROM tbl_sample 
            WHERE id = '".$_POST["id"]."'
        ";

        $statement = $connect -> prepare($query);
        $statement -> execute(); //sorgu yapılıyor mysql'e
        $resultArr =  $statement -> fetchAll(); //sorgu sonucu gelen veri array olarak çekiliyor
        foreach($resultArr as $row)
        {
            $output['first_name'] = $row['first_name'];
            $output['last_name'] = $row['last_name'];
        }
        echo json_encode($output); //ajaxa geri gönderilen veri
    }


    //update data from mysql
    if($_POST["action"] == "update"){
        $query = "
		    UPDATE tbl_sample 
		    SET first_name = '".$_POST["first_name"]."', 
		    last_name = '".$_POST["last_name"]."' 
		    WHERE id = '".$_POST["hidden_id"]."'
        ";

        $statement =  $connect -> prepare($query);
        $statement -> execute();  //sorgu yapılıyor mysql'e
        echo '<p> Data Updated </p>';   //ajaxa geri gönderilen veri
    }


    //Delete single data from mysql
    if($_POST["action"] == "delete"){
        $query = "
            DELETE FROM tbl_sample 
            Where id = '".$_POST["id"]."' 
        ";


        $statement = $connect -> prepare($query);
        $statement -> execute();  //sorgu yapılıyor mysql'e
        echo '<p>Data Deleted</p>'; //ajaxa geri gönderilen veri
    }


}



?>



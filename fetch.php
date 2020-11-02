<?php

//fetch.php

include("database_connection.php");

$query= "
    SELECT * 
    FROM tbl_sample;
";

$statement = $connect->prepare($query);
$statement -> execute(); //sorgu yapılıyor mysql'e
$resultArr = $statement -> fetchAll(); //mysql sorgu sonucu olan tablo  array olarak fetch edilir
$total_row = $statement -> rowCount(); //mysql sorgu sonucu tablo satırını verir

$output = '
    <table class="table table-striped table-bordered">
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Edit</th>
        <th>Delete</th>
';
if($total_row > 0){
    foreach($resultArr as $row){
        $output .= '
            <tr>
                <td width="40%">' .$row["first_name"]. '</td>
                <td width="40%">' .$row["last_name"]. '</td>
                <td width="10%">
                    <button type="button" name="edit" class="btn btn-primary btn-xs edit" id="' .$row["id"]. '">Edit</button>
                </td>
                <td width="10%">
                    <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' .$row["id"]. '">Delete</button>
                </td>
            </tr>        
        ';
    }
}
else{
    $output .= '
	<tr>
		<td colspan="4" align="center">Data not found</td>
	</tr>
    ';
}
$output .= '</table>';
echo $output;

?>
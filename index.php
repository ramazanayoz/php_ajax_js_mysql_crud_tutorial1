<html>
    <head>

        <title>PHP Ajax Crud using JQuery UI Dialog</title>  

        <!--//*JQUERY BOOTSTRAP LİNKS*/-->
		<link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>    
    
    </head>

    <body>

        <!--//**user list table*/-->
        <div class="container">            
            <br>
            <h3 align="center"><a>Ajax Crud using JQuery UI Dialog</a></h3>
            <br>
            <br>
            <div align="right" style="margin-bottom:5px;">
			    <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
            </div>
            <div class="table-responsive" id="user_data">
                //fetch data here
            </div>
            <br>
        </div>

        <!--//*Edit user form */-->
        <div id="user_dialog" title= "Add Data">
            <form method="post" id="user_form">
                <div class="form-group">
                    <label>Enter First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control">
                    <span id="error_first_name" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Enter Last Name</label>
                    <input type="text" name= "last_name" id="last_name" class="form-control">
                    <span id="error_last_name" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <input type="submit" name="form_action" id="form_action" class="btn btn-info" value = "Insert">
                </div>
            </form>
        </div>

        <div id="action_alert" title= "Action">
            //fetch data here
        </div>

        <div id="delete_confirmation" title="Confirmation">
            <p>Are you sure you want to Delete this data?</p>
        </div>


    </body>

</html>




<script>

    //jquery
    $(document).ready(function(){
        
        load_data();
        
        //load data and set to user list table
        function load_data(){
            $.ajax({
                url: "fetch.php",
                method: "POST",
                success: function(data){ //server fetch.php' den response olarak gelen data 
                    $('#user_data').html(data);
                }
            });
        }

        //open as a dialog user edit formu
        $("#user_dialog").dialog({
            autoOpen: false,
            width: 400
        });

        $('#add').click(function(){
            $('#user_dialog').attr('title', 'Add Data');
		    $('#action').val('insert');
		    $('#form_action').val('Insert');
		    $('#user_form')[0].reset();
		    $('#form_action').attr('disabled', false);
		    $("#user_dialog").dialog('open');
        });

        $('#user_form').on('submit', function(event){
            event.preventDefault();
            var error_fist_name = '';
            var error_last_name = '';
            
            if($('#first_name').val == ''){
                error_first_name = 'First name is required';
                $('#error_first_name').text(error_first_name);
                $('#first_name').css('border-color', '#cc0000');
            }
            else{
                error_first_name = '';
			    $('#error_first_name').text(error_first_name);
			    $('#first_name').css('border-color', '');
            }
            if($('#last_name').val() == ''){
			    error_last_name = 'Last Name is required';
			    $('#error_last_name').text(error_last_name);
			    $('#last_name').css('border-color', '#cc0000');
		    }   
		    else{
			    error_last_name = '';
			    $('#error_last_name').text(error_last_name);
			    $('#last_name').css('border-color', '');
		    }

            if(error_first_name != '' || error_last_name != ''){
                return false;
            }
            else{
                //if validation is succesfull, record user to db
                $('#form_action').attr('disabled', 'disabled') //close the form 
                var form_data = $(this).serialize();
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data: form_data,
                    success: function(data){ //action.php'ye post req yapılır ve response alınır
                        $('#user_dialog').dialog('close');
                        $('#action_alert').html(data);
                        $('#action_alert').dialog('open');
                        load_data();
                        $('#form_action').attr('disabled', false);
                    }
                });
            }
        });


        $('#action_alert').dialog({
            autoOpen: false
        });

        //user bilgileri fetch ediliyor edit butona basılınca ve forma atanıyor
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            var action = 'fetch_single';
            $.ajax({
                url: "action.php", //req yapılacak adres
                method: "POST", //post req yapılacak
                data: {id:id, action: action}, // servere gönderilen data
                dataType: "json", //response olarak gelen veri tipi
                success:function(data){  //serverdan gelen response data
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#user_dialog').attr('title', 'Edit Data');
                    $('#action').val('update');
                    $('#hidden_id').val(id);
                    $('#form_action').val('Update');
                    $('#user_dialog').dialog('open');
                }
            });
        });


        $('#delete_confirmation').dialog({
            autoOpen:false,
            modal: true,
            buttons:{
                Ok : function(){
                    var id = $(this).data('id');
                    var action = 'delete';
                    $.ajax({
                        url:"action.php",
                        method:"POST",
                        data:{id:id, action:action},
                        success:function(data)
                        {
                            $('#delete_confirmation').dialog('close');
                            $('#action_alert').html(data);
                            $('#action_alert').dialog('open');
                            load_data();
                        }
                    });
                },
                Cancel : function(){
                    $(this).dialog('close');
                }
            }	
        });
	
        //
        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            $('#delete_confirmation').data('id', id).dialog('open');
        });

    });




</script>
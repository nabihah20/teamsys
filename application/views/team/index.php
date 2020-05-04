<div class="container"> 
    <div class="alert alert-success" style="display: none;">
		
    </div>
    <div class="form-group col-md-12" style="text-align:right;">
        <button id="btnAdd" class="btn btn-primary">+ New Team</button>
    </div>
    <table class="table table-bordered table-responsive table-hover table-dark">
        <thread>
            <tr>
                <td>No.</td>
                <td>Team Name</td>
                <td>Lead Name</td>
                <td>Team Members</td>
                <td>Viewed</td>
            </tr>
        </thread>
        <tbody id="showdata">

        </tbody>
    </table>
</div>

<!-- Start Add modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Team</h4>
      </div>
      <div class="modal-body">
        <form id="myForm" action="" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="team_name" class="label-control col-md-4">Team Name</label>
                <div class="col-md-8">
                    <input type="text" name="txtTeamName" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="lead_name" class="label-control col-md-4">Lead Name</label>
                <div class="col-md-8">
                    <input type="text" name="txtLeadName" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="member_name" class="label-control col-md-4">Member Name</label>
                <div class="field_wrapper col-md-8">
                    <input type="text" name="txtMemberName[]" class="form-control col-md-6">    
                </div>
                <div class="col-md-12" style="text-align:right;">
                    <br>         
                    <a href="javascript:void(0);" class="btn btn-primary add_button" title="Add field">+ More Member</a>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSave" class="btn btn-primary">Add Team</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Add modal -->


<script type="text/javascript" language="javascript" >
    $(function(){
        showAllTeam();

        //Add New Button
        $('#btnAdd').click(function(){
            $('#myModal').modal('show');
            $('#myModal').find('.modal-title').text('Add New Team');
            $('#myForm').attr('action','<?php echo base_url() ?>team/addTeam');
        });

        //Button Add Whole Team
        $('#btnSave').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();
			//validate form
            var tname = $('input[name="txtTeamName"]');
            var lead_tname = $('input[name="txtLeadName"]');
            var member = $('input[name="txtMemberName[]"]').map(function(){ 
                    return this.value; 
                }).get();
			var result = '';
			if(tname.val()==''){
				tname.parent().parent().addClass('has-error');
			}else{
				tname.parent().parent().removeClass('has-error');
				result +='1';
			}
			if(lead_tname.val()==''){
				lead_tname.parent().parent().addClass('has-error');
			}else{
				lead_tname.parent().parent().removeClass('has-error');
				result +='2';
			}

            if(member == ''){
                alert('Enter Member');
                return false;
            }

			if(result=='12'){
				$.ajax({
					type: 'ajax',
					method: 'post',
					url: url,
                    data: data,
					async: false,
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#myModal').modal('hide');
							$('#myForm')[0].reset();
							if(response.type=='add'){
								var type = 'added'
							}else if(response.type=='update'){
								var type ="updated"
							}
							$('.alert-success').html('Team '+type+' successfully').fadeIn().delay(4000).fadeOut('slow');
							showAllTeam();
						}else{
							alert('Error');
						}
					},
					error: function(){
						alert("Try again");
					}
				});
			}
		});

        //Button view team
        $(document).on('click', '.item-view', function(){
        var id = $(this).attr('data');
        var options = {
            ajaxPrefix: '',
            ajaxData: {id:id},
            ajaxComplete:function(){
                this.buttons([{
                type: Dialogify.BUTTON_PRIMARY
                }]);
            }
        };
        new Dialogify('fetch_teamDetails.php', options)
            .title('Team Details')
            .showModal();
        });

        //function 
       function showAllTeam(){
            $.ajax({
                type: 'ajax',
                url:'<?php echo base_url() ?>team/showAllTeam',
                async: false,
                dataType: 'json',
                success: function(data){
                    var html = '';
                    var i;
                    $counter = 1; 
                    $count=1;

                    for(i=0; i<data.length; i++){

                        html +='<tr>'+  
                                '<td>'+$counter+'</td>'+
                                '<td>'+data[i].tname+'</td>'+
                                '<td>'+data[i].lead_tname+'</td>'+                                    
                                '<td>'+data[i].member+'<br>'+'</td>'+    
                                '<td>'+
                                    '<a href="javascript:;" class="btn btn-success item-view" name="item-view" data="'+data[i].id+'">View</a>'+
                                    //'<a href="javascript:;" class="btn btn-info item-edit" data="'+data[i].id+'">Edit</a>'+
                                    //'<a href="javascript:;" class="btn btn-danger item-delete" data="'+data[i].id+'">Delete</a>'+
                                '</td>'+
                            '</tr>';
                            $counter++;
                        }
                    
                    $('#showdata').html(html);
                },
                error: function(){
                    alert('Could not get data from database');
                }
            });

        }
    });
</script>
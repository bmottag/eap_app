<!-- FullCalendar -->
<link href="<?php echo base_url("assets/bootstrap/vendors/fullcalendar/dist/fullcalendar.min.css"); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/bootstrap/vendors/fullcalendar/dist/fullcalendar.print.css"); ?>" rel="stylesheet" media="print">

<div class="right_col" role="main">

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class='fa fa-calendar'></i> CALENDAR </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  			  
<script>
	   	/* CALENDAR */
		$(document).ready(function() {

				if( typeof ($.fn.fullCalendar) === 'undefined'){ return; }
				console.log('init_calendar');
					
				var date = new Date(),
					d = date.getDate(),
					m = date.getMonth(),
					y = date.getFullYear(),
					started,
					categoryClass;

				var calendar = $('#calendar').fullCalendar({
				defaultView: "listMonth",
				locale: 'es',
				  header: {
					left: 'prev,next today',
					center: 'title',
					right: 'agendaWeek,listMonth'
				  },
				  buttonText: {
					  today:    'Today',
					  month:    'Month',
					  week:     'Week',
					  day:      'Day',
					  list:     'List'
				  },
				  selectable: true,
				  selectHelper: true,
				  select: function(start, end, allDay) {
					$('#fc_create').click();

					started = start;
					ended = end;

					$(".antosubmit").on("click", function() {
					  var title = $("#title").val();
					  if (end) {
						ended = end;
					  }

					  categoryClass = $("#event_type").val();

					  if (title) {
						calendar.fullCalendar('renderEvent', {
							title: title,
							start: started,
							end: end,
							allDay: allDay
						  },
						  true // make the event "stick"
						);
					  }

					  $('#title').val('');

					  calendar.fullCalendar('unselect');

					  $('.antoclose').click();

					  return false;
					});
				  },
				  eventClick: function(calEvent, jsEvent, view) {
					$('#fc_edit').click();
					$('#title2').val(calEvent.title);

					categoryClass = $("#event_type").val();

					$(".antosubmit2").on("click", function() {
					  calEvent.title = $("#title2").val();

					  calendar.fullCalendar('updateEvent', calEvent);
					  $('.antoclose2').click();
					});

					calendar.fullCalendar('unselect');
				  },
				  editable: true,
				  
				  events: [
				  
<?php
if($information){
	foreach ($information as $data):
?>
				  {
					title: '<?php 
							echo " Project: $data[project_name] - ";
							echo " Company: $data[company_name] - ";
							echo " Observation: $data[observation] - ";
							echo " Quantity: $data[quantity]";
							?>',
					start: '<?php echo $data["date_programming"] . " 08:00"; ?>',
					end: '<?php echo $data["date_programming"] . " 17:00"; ?>',
					url: '<?php echo base_url("programming/index/$data[id_programming]"); ?>',
					description: 'This is a cool event'
				  },
				  
<?php
		endforeach;
	}
?>
				  
				  ]
				});
		});
</script>
				  				  

                    <div id='calendar'></div>

                  </div>
                </div>
              </div>

</div>

    <!-- calendar modal 
    <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary antosubmit">Save changes</button>
          </div>
        </div>
      </div>
    </div>
	-->
	
	
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Datos reserva</h4>
          </div>
          <div class="modal-body">

            <div id="testmodal2" style="padding: 5px 20px;">
              <form id="antoform2" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <div class="col-sm-12">
					<textarea class="form-control" id="title2" name="title2" rows="5" disabled></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
    <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
    <!-- /calendar modal -->

<!-- bootstrap-datetimepicker -->    	
<script src="<?php echo base_url("assets/bootstrap/vendors/moment/min/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/bootstrap/vendors/fullcalendar/dist/fullcalendar.min.js"); ?>"></script>
	$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		
		var course = $( "#Curso" ),
			discipline = $( "#Disciplina" ),
			allFields = $( [] ).add( course ).add( discipline ),
			tips = $( ".validateTips" );
		
		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		function checkRequired( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Campo " + n + " é obrigatório.");
				return false;
			} else {
				return true;
			}
		}		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 350,
			width: 300,
			modal: true,
			buttons: {
				"Reservar": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					//bValid = bValid && checkRequired( course, "Curso", 1, 100 );
					bValid = bValid && checkRequired( discipline, "Disciplina", 1, 100 );
					

					if ( bValid ) {
						
						var cursoSel = $("#Curso").val();
						var disciplineSel = $("#Disciplina").val();
						var continuousCheck = $("#Recorrente").is(':checked');
						
						$('#action').val('makeReserve');
						$("#ReserveCourseSelected").val(cursoSel);
						$("#ReserveDisciplineSelected").val(disciplineSel);
						$("#ReserveContinuous").val(continuousCheck);
						
						
						$('#ReserveCalendarForm').submit();
						
						$( this ).dialog( "close" );
					}
				},
				"Cancelar": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
		/*
		$( ".create-user" )
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});
			*/
	});
	

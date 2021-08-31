var domain   = location.origin+location.pathname;

function setCookie(c_name,value,exdays) {
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays===null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name) {
    var name = c_name + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name)===0) return c.substring(name.length,c.length);
    }
    return "";
}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
	'use strict'
  
	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')
  
	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
	  .forEach(function (form) {
		form.addEventListener('submit', function (event) {
		  if (!form.checkValidity()) {
			event.preventDefault()
			event.stopPropagation()
		  }
  
		  form.classList.add('was-validated')
		}, false)
	  })
  })()

jQuery(document).ready(function() {

	Messenger.options = {
		extraClasses: 'messenger-fixed messenger-on-top  messenger-on-right',
		theme: 'flat',
		messageDefaults: {
			showCloseButton: true
		}
	}

	//tooltips
	$(".hasTip").tooltip();

	//colorpickers
	if ($('#color').length) {
		$('#color').colorpicker();
	}

	//save cookie with language
	$('.lang').click(function() {
		var lang = $(this).attr('data-lang');
		setCookie('language', lang, 10);
    });

    $('#readMessages').click(function(e) {
    e.preventDefault();
    $.get(domain+'?view=home&task=readMessages&mode=raw');
    $('.badge').html('0');
    $('.messages').empty();
    Messenger().post({message: "Eureka! no hi han més missatges", type: 'success', hideAfter: 10});
	});

    $('.readMessage').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var href = $(this).attr('href');
    $.get(domain+'?view=home&task=readMessages&mode=raw&id='+id);
    document.location.href = domain+href;
	});

	//select all checkbox
	$('#selectAll').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		checkboxes.prop('checked', $(this).is(':checked'));
	});

	function deleteAccount(username, domain) {
		if($('#proceed').val().toLowerCase() == username) {
			document.location.href = domain+'?view=config&task=deleteAccount';
		} else {
			return false;
		}
	}

	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

});

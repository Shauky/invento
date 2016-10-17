$('document').ready(function() {
	$('form[name=new-user]').submit(function(evt) {
		evt.preventDefault();
		
		var name = $('input[name=nuser-name]').val();
		var username = $('input[name=nuser-user]').val();
		var password = $('input[name=nuser-pass]').val();
		var password2 = $('input[name=nuser-passr]').val();
		var email = $('input[name=nuser-email]').val();
		var role = $('select[name=nuser-role]').val();
		
		// Validate email
		var rgpx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		// Empty Inputs
		if(name == '') {
			alert('Please insert a name');
			return false;
		}else if(username == '') {
			alert('Please insert a username');
			return false;
		}else if(password == '') {
			alert('Please insert a password');
			return false;
		}else if(password2 == '') {
			alert('Please insert the password confirmation');
			return false;
		}else if(email == '') {
			alert('Please insert an email');
			return false;
		}else if(password != password2) {
			alert('Passwords don\'t match');
			return false;
		}else if(rgpx.test(email) == false) {
			alert('Please insert a valid email');
			return false;
		}else if(password.length < 6){
			alert('Password must be at least 6 characters long');
			return false;
		}
		
		
		$.post('new-user.php', {
			'act':'1',
			'name':name,
			'username':username,
			'password1':password,
			'password2':password2,
			'email':email,
			'role':role
		}, function(data) {
			if(data == '1') {
				alert('User successfully created');
				location.href = 'new-user.php';
			}else if(data == '2') {
				alert('Passwords don\'t match');
				return false;
			}else if(data == '3') {
				alert('Please insert a valid email');
				return false;
			}else if(data == '4') {
				alert('Password must be at least 6 characters long');
				return false;
			}else if(data == '5') {
				alert('Username already exists');
				return false;
			}else{
				alert('Something went wrong, please try again');
				return false;
			}
		});
	});
});
//Basic functionality for now. PHP will handle most dynamic content.
//Example, to show the user section when logged in, or the herb details.
//example show the user section.
document.addEventListener('DOMContentLoaded', function() {
    //Example, if user is logged in, show user section.
    let loggedIn = false; //Change to true for testing.
    if (loggedIn){
        document.getElementById('user-section').classList.remove('hidden');
    }
  });
$("#navBtn").click(function(){
    $("#navMobile").toggle();
  });
  
  $("#navMobileClose").click(function(){
    $("#navMobile").toggle();
  });
  
  feather.replace();
  
  $("#close-notification").click(function() {
      
      $("#notification").fadeOut("fast", function() {
          $("#notification").remove();
      });
  
  });
$(function(){    
  $("#exercise").click(function(){
    $("#exercise_menu").fadeIn();
  });
  $("#no").click(function(){
    $("#exercise_menu").fadeOut();
  });
  $("#yes").click(function(){
    $("#exercise_menu").fadeOut();
    $("#sich2").addClass("exercise_now");
    $("#sich1").removeClass("exercise_now");
    $("#exercise_form").fadeIn();
  });
});


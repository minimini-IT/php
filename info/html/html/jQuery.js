$(function(){    
  $("#exercise").click(function(){
    $("#exercise_menu").fadeIn();
  });
  $("#no").click(function(){
    $("#exercise_menu").fadeOut();
  });
  $("#yes").click(function(){
    $("#exercise_menu").fadeOut();
    $("#exercise_form").fadeIn();
  });
  $("#back").click(function(){
    $("#exercise_form").fadeOut();
  });
});


$(function(){
  exercise = 0;
  $("#yes").click(function(){
    $("#exercise_form").fadeIn();
    exercise = 1;
  });
  $("#no").click(function(){
    $("#exercise_form").fadeOut();
  });
  if (exercise == 1) {
    $(".swich").text("演習開催中!!");
  }
});
/*$function(){
  var $i = 100;
  $.ajax({
    type:"POST",
    url:"test1.php",
    data:$i,
    success:function(data){
      alert(data);
   }
  });
});
*/


/*$(function(){
  var exercise = 0;
  console.log(exercise);
  $("#exercise_start").click(function(){
    exercise = 1;
    console.log(exercise);
  });
  $("#exercise_end").click(function(){
    exercise = 0;
    console.log(exercise);
  });
  $.ajax({
    type:"POST",
    url:"test.php",
    data:exercise,
    success:function(response){
      alert("送信完了！\nレスポンスデータ："+response);
    }
  });
});*/

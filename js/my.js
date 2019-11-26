$(function() {
  $.ionSound({
    sounds: [
      "water_droplet",
      "bell_ring",
      "metal_plate"
    ],
    path: "sounds/"
  });
  $("#sound1").on("click", function(){
    $.ionSound.play("water_droplet");
  });
  $("#sound2").on("click", function(){
    $.ionSound.play("bell_ring");
  });
  $("#sound3").on("click", function(){
    $.ionSound.play("metal_plate");
  });

});
// $(window).on('load', function(){
//   if($(window).width()<=786){
//     $("#big_search").addClass("hidden");
//     $("#small_search").removeClass("hidden");
//   }else{
//     $("#big_search").removeClass("hidden");
//     $("#small_search").addClass("hidden");
//
//   }
//
//     })
//
// $(window).on("resize", function(){
//   if($(window).width()<=786){
//     console.log($(window).width());
//     $("#big_search").addClass("hidden");
//     $("#small_search").removeClass("hidden");
//   }else{
//     $("#big_search").removeClass("hidden");
//     $("#small_search").addClass("hidden");
//
//   }
//
//     })
//

/**
 * Listen to scroll to change header opacity class
 */
function checkScroll(){

    var startY = $('.navbar#top_nav').height() * 0.1; //The point where the navbar changes in px

    if($(window).scrollTop() > startY){
        $('.navbar#top_nav').addClass("scrolled");
    }else{
        if(($("#bs-example-navbar-collapse-1").is(":visible")) == false){
        console.log("toggle is open")};
        $('.navbar#top_nav').removeClass("scrolled");
    }
}

if($('.navbar#top_nav').length > 0){
    $(window).on("scroll load resize", function(){
        checkScroll();
    });
}


$(".navbar-toggle.collapsed").on("click", function(){
  if(($("#bs-example-navbar-collapse-1").is(":visible")) == false){
  console.log("toggle is open");
  $('.navbar#top_nav').addClass("scrolled");}else{
    checkScroll();
  };})


  $(".panel-footer").on("click", function(){
    if(($("#collapseOne").is(":visible")) == false){
      document.querySelector(".panel-title").textContent = "Click to see less votes";
    // $('.navbar').addClass("scrolled");
  }else{
      document.querySelector(".panel-title").textContent = "Click to see more votes"
      // checkScroll();
    };})


  $("#about").on("click",function(){

    $(".profile_about").removeClass("hidden");
    $("#about").addClass("current");


    $(".profile_deals").addClass("hidden");
    $("#deals").removeClass("current");

    $(".profile_talk").addClass("hidden");
    $("#talk").removeClass("current");

    $(".profile_votes").addClass("hidden");
    $("#votes").removeClass("current");

  })

  $("#deals").on("click",function(){

    $(".profile_about").addClass("hidden");
    $("#about").removeClass("current");


    $(".profile_deals").removeClass("hidden");
    $("#deals").addClass("current");

    $(".profile_talk").addClass("hidden");
    $("#talk").removeClass("current");

    $(".profile_votes").addClass("hidden");
    $("#votes").removeClass("current");
  })


  $("#talk").on("click",function(){

    $(".profile_about").addClass("hidden");
    $("#about").removeClass("current");


    $(".profile_deals").addClass("hidden");
    $("#deals").removeClass("current");

    $(".profile_talk").removeClass("hidden");
    $("#talk").addClass("current");

    $(".profile_votes").addClass("hidden");
    $("#votes").removeClass("current");

  })

  $("#votes").on("click",function(){

    $(".profile_about").addClass("hidden");
    $("#about").removeClass("current");


    $(".profile_deals").addClass("hidden");
    $("#deals").removeClass("current");

    $(".profile_talk").addClass("hidden");
    $("#talk").removeClass("current");

    $(".profile_votes").removeClass("hidden");
    $("#votes").addClass("current");

  })


  $(window).on('load', function(){

      $(".profile_about").removeClass("hidden");
      $("#about").addClass("current");


      $(".profile_deals").addClass("hidden");
      $("#deals").removeClass("current");

      $(".profile_talk").addClass("hidden");
      $("#talk").removeClass("current");

      $(".profile_votes").addClass("hidden");
      $("#votes").removeClass("current");

      })


// 786




   //  var elmnt = document.createElement("li");
   //     var textnode = document.createTextNode("Water");
   //     elmnt.appendChild(textnode);
   //
   //     var item = document.getElementById("myList");
   //     item.replaceChild(elmnt, item.childNodes[0]);
   // }

    // var textnode = document.createTextNode("Water");
    //     var item = document.getElementById("myList").childNodes[0];
    //     item.replaceChild(textnode, item.childNodes[0]);
    // }

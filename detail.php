<?php


     $mgid = (isset($_GET['mgid'])) ? $_GET['mgid'] : "bc16b4b4-1f0f-41f1-ab31-8d6a0816a7b9    ";
     /*
     http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22*%22:1,%22Platforms%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}},%22Screenshots%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}}},%22where%22:{%22byId%22:[%22".$mgid."%22]}}&indent=true&stage=authoring
    
     $arcRequest = http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22*%22:1,%22Platforms%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}},%22Screenshots%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}}},%22where%22:{%22byId%22:[%681392ab-7ad3-4d4e-8e10-31953d19f5e9%22]}}&indent=true&stage=authoring
     
     http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}},%22Screenshots%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}},%22where%22:{%22byId%22:[%22a523bf91-970b-431b-9f26-8871412ee343%22]}}&indent=true&stage=authoring
     
     
      */
     
     $arcRequest = 
"http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}},%22Screenshots%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}},%22where%22:{%22byId%22:[%22".$mgid."%22]}}&indent=true&stage=authoring";
         
     $jsonContents = file_get_contents($arcRequest);
     $jsonArray = json_decode($jsonContents,true);
    $description = $jsonArray["response"]["docs"]["0"]["Description"];
    $detailTitle =  $jsonArray["response"]["docs"]["0"]["Title"];
    $payURI = $jsonArray["response"]["docs"]["0"]["PayURI"];
    $price = $jsonArray["response"]["docs"]["0"]["Price"];
    $thumbNail =  "http://mtv.mtvnimages.com/uri/".$jsonArray["response"]["docs"]["0"]["Images"]["0"]["ImageAssetRefs"]["0"]["URI"]."?width=90";
   
?>
<html>
     <head>
          <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" >
          <meta charset="UTF-8">
          
          <link rel='stylesheet' type='text/css' href="styles/cstdefault.css" >
          
          <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
           <script src="lib/swipe.js"></script>
     </head>
     <body>
         <div id="container">
          <div id="detailHeader">
              <div class="detailButton" id="backBtn" >&lt;&nbsp;Back to Apps</div>
          </div>
          <div id="purchaseInfo">
               <div id="detailThumbnail" style="background: url('<?php echo($thumbNail); ?>') no-repeat center center;">
               </div>
               <div id="metadata">
                    <div id="detailTitle"><?php echo($detailTitle) ?></div>
                    <div id="price"><?php echo($price) ?></div>
                    <div id="action"><div class="detailButton">BUY</div></div>
               </div>
          </div>
          <div id="detailDescription">
           <?php echo($description) ?>
          </div>
          
          <h2 >Screen Shots</h2>
          <div id="screenShotSlider" >
               <ul id="slider_list" ></ul>
           </div>	
          <ul id="indicator" ></ul>
         </div>
     </body>
     <script src="lib/slides.js" type="text/javascript" charset="utf-8"></script>
     <script>
          var showChar = 150;
          var isLandscape = true;
          var pageType = "detail";
          var ellipsestext = "...";
          var moretext = "more";
          var lesstext = "less";
          var content = $("#detailDescription").html();
          var lightbox;
          
          
          if(content.length > showChar) {
               var c = content.substr(0, showChar);
               var h = content.substr(showChar, content.length - showChar);
               
               var html = c + '<span class="moreelipses">'+ellipsestext+'</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';
               
               $("#detailDescription").html(html);
          }
          $(".morelink").click(function(){
               if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
               } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
               }
               $(this).parent().prev().toggle();
               $(this).prev().toggle();
               return false;
          }
          );
          
          $("#backBtn").click(function() {
               $("body").hide();
               window.history.back();
          });
          
          
                
          function positionIndicator() {
             
               var screenShotSliderRef =  $('#screenShotSlider').width()/2;
               var indicatorRef = $('#indicator').width()/2;
               var windowWidth = $("#screenShotSlider").offset().left + screenShotSliderRef - indicatorRef;
               
               if ( windowWidth > 0) {
                    document.getElementById('indicator').setAttribute("style","margin-left:"+windowWidth+"px; visibility:visible");
               } 
               
          }
                
          function buildCarousel() {
               
               var rawData = <?php echo($jsonContents); ?>;
               console.log(rawData);
               var screenShots = rawData.response.docs[0].Screenshots[0].ImageAssetRefs;
              
               var image = "";
               $("#indicator").hide();
               for ( var index = 0; index < screenShots.length; index++) {
                   var  imageURL =   "http://mtv.mtvnimages.com/uri/"  + screenShots[index].URI;
                    
                    //construct layout for display item
                    var screenshotId = "id='" + index + "'";
                    var liTag = "<li  " + screenshotId +" >";
                    var displayItem = liTag + '<div class="screenShotItem"><img class="screenShotImage" src="' +imageURL+ '" border="0"></div></li>'	
                    //var displayItem = liTag + '<div class="screenShotItem"></div></li>'	
                    // add display item to the carousel display  list
                   $("#slider_list").append(displayItem);
                    var theId = "#" + index;
                    var elem = $(theId);
                    
                   elem.bind("click",function(e){
                              e.preventDefault();
                              lightbox.show($(this).attr("id"));
                         });
                    $("#indicator").append('<li><img src="http://a10.akadl.mtvnservices.com/10740/cdnorigin/mobilestor/nick.com/cst/NUb_off.jpg" /></li>');
               }
                    
               //create the Carousel ( Swipe ) component )	
               screenShotSlider = new Swipe(document.getElementById("screenShotSlider"));
               positionIndicator();
               
               if (screenShotSlider.slides.length > 1){
                    screenShotSlider.next();
               }

          }
          
          $(document).ready(function() { 
          
               window.scrollTo(0,1); 
               buildCarousel();
               
               lightbox = new saw.Lightbox('#screenShotSlider');

              /* $('.screenShotItem').click( function(e){
                    
               });*/
          
           });
          
     </script>
</html>
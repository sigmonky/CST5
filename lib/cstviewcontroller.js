var isLandscape = false;
var pageType = "landing";
var rowStarts = [];
var leftSide  = 0;
var totalItems = 0;
var selectedItem = "";
var previousOrientation = window.orientation;
var slider;
var lastItemTop;
var appURIs = "";
var client = "";


function positionIndicator() {
     //var sliderRef =  document.getElementById('slider').getBoundingClientRect().width/2;
     var sliderRef =  $('#slider').width()/2;
     //var indicatorRef = document.getElementById('indicator').getBoundingClientRect().width/2;
     var indicatorRef = $('#indicator').width()/2;
     var windowWidth = $("#slider").offset().left + sliderRef - indicatorRef;
     
     if ( windowWidth > 0) {
          document.getElementById('indicator').setAttribute("style","margin-left:"+windowWidth+"px; visibility:visible");
     } 
     
}


//initialize Omniture tracking
mtvn.btg.Controller.init();
$(document).ready(function(){
     
     $("#cst_crm-submit").bind("click",function() {
               //MOBAPLAT-810 -- 1120 email submission
               /*
                eVar1	 Referring App	 The Daily Show Headlines
               event5	 Email address submitted	 Email address submitted
               */
              
                mtvn.btg.Controller.sendLinkEvent(
                     {
                         linkName: "email submit",
                         eVar1:cstInventory.referringApp,
                         events:"event 5",
                         evar31:"viaappcst",
                         prop48:"viaappcst",
                     }
                );   
     });
    
     cstInventory.parse(rawData.response.docs[0].Items);  
     rawData = null;      
     buildPage();
     
     if(UA.iphone){
          client = 'iphone';
     }else if(UA.android){
          client = 'android';
     }
     
     
}); // end $(document).ready event handler
               
function showDetailPage( selectedItem ) {
      var indices = selectedItem.split(":");
     var gridNum = indices[0];
     var appNum = indices[1];
     var appId = cstInventory.gridItems[gridNum].apps[appNum]["mtvi:id"];
     var detailURL = "detail.php?mgid="+ appId;
   window.location = detailURL;
}

function buildCarousel() {

     var featuredApps = cstInventory.featuredItems;
     var image = "";
     $("#indicator").hide();
     for ( var index = 0; index < featuredApps.length; index++) {
          /*if ( featuredApps[index].image != "" ) {
               imageURL =featuredApps[index].image["@attributes"].url;
          } else {*/
          //imageURL = "http://a12.akadl.mtvnservices.com/10740/cdnorigin/mobilestor/nick.com/cst/diner_dashsmall_feature.png"
          //}
          imageURL =  "http://mtv.mtvnimages.com/uri/" + featuredApps[index].Platforms[0].Images[0].ImageAssetRefs[0].URI
          appURL = featuredApps[index].Platforms[0].PayURI;
          
          //construct layout for display item
          var featuredItemId = "id='featured-" + index + "'";
          var appName = "appname='" + featuredApps[index].Title + "'";
          var liTag = "<li  " + featuredItemId +" " + appName  + ">";
          
          //var displayItem = liTag + '<div class="carouselImage"><a target="_blank" href="' + appURL+'"><img class="featuredRoundedCorners" src="' +imageURL+ '" border="0"></a></div></li>'	
         
          //var displayItem = liTag + '<div class="carouselImage"><a target="_blank" href="' + appURL+'"><img class="featuredRoundedCorners" src="' +imageURL+ '" border="0"></a></div></li>'	
          var displayItem = liTag + '<div class="featuredItem"><img class="featuredItemThumb" src="' +imageURL+ '" border="0"></div></li>'	
          // add display item to the carousel display  list
         $("#slider_list").append(displayItem);
         
          // add new element in carousel indicator
          var theId = "#featured-" + index;
          var elem = $(theId);
          
          elem.bind("click",function(){
             
               var appName = $(this).attr("appname"),
                      appSlot = parseInt($(this).attr("id").split("-")[1]) + 1,
                     
              
              appSlot = "Featured " + appSlot.toString();
              //MOBAPLAT-810 -- 1113 -- Tap on any app in a featured location
               /*
                    eVar1	 referring app	 The Daily Show Headlines
                    eVar2	 destination app	 Futurama Head in a Jar
                    eVar3	 Featured <Slot Number>	 Featured 1, Featured 2
                    event2	 Click to the <store name>	 Click to the iTunes Store
              */
             
               mtvn.btg.Controller.sendLinkEvent(
                     {
                         linkName: "click to " + theStore,
                         eVar1:cstInventory.referringApp,
                         eVar2:appName,
                         eVar3:appSlot,
                         evar6:theStore,
                         events:"event 2",
                         evar31:"viaappcst",
                         prop48:"viaappcst",
                     }
                  
               );
              
          });
          $("#indicator").append('<li><img src="http://a10.akadl.mtvnservices.com/10740/cdnorigin/mobilestor/nick.com/cst/NUb_off.jpg" /></li>');
     }
          
     //create the Carousel ( Swipe ) component )	
     slider = new Swipe(document.getElementById('slider'));
     positionIndicator();
     
     //move to 2nd item in Carousel in landscape mode
     if (isLandscape == true){
          if (slider.slides.length > 1){
               slider.next();
          }
     }
}

function buildCategories() {
          //build the apps grid
          var gridItems = cstInventory.gridItems[0].apps;
          
          $("#category1").append(cstInventory.gridItems[0].title);
          totalItems = gridItems.length;
          
          for ( var index = 0; index < gridItems.length; index++) {
               //var description = gridItems[index].Description;
               var name =  gridItems[index].Title;
               if ( name.length > 50 ) {
                   name = name.substring(0,49) + "...";
               }
     
              // if ( gridItems[index].image != "" ) {
                    //var image = gridItems[index].image["@attributes"].url;
              // } else {
                   // var image = "http://a12.akadl.mtvnservices.com/10740/cdnorigin/mobilestor/nick.com/cst/diner_dashsmall_feature.png"
              // }
              var image =  "http://mtv.mtvnimages.com/uri/" +gridItems[index].Images[0].ImageAssetRefs[0].URI
     
              $("#appsGrid").append("<div  id='0:"+ (index )+"' class='categoryItem' ><img class='categoryItemThumb' src='"  + image + "'/><p class='categoryItemName'>"+ name+ "</p></div>");
              
              
     }
     
     // apps grid item selection handler
     $(".categoryItem").each( function(index,item) {
          $(this).bind("click",function() {  
               selectedItem = $(this).attr("id");
               if ( selectedItem != "" ) {
                   showDetailPage(selectedItem);
               }
          });
     });
     
     $("input").each( function(index,item) {
          $(this).bind("focus",function() {
               if ( $(this).attr("initial-text") == $(this).val() ) {
                    $(this).val("");
                    $(this).css("color","rgb(0,0,0)");
               }
          });
     });
}

function buildPage(event) {
         // $("#header").html("wrapper version:" + qs("wrapperversion"));
          buildCarousel();
          
          //update display based on orientation setting provided by wrapper app. Note: may be different from actual orientation.
          
          if ( qs('orientation') ) {
               didRotateTo(qs('orientation'));
          } else {
               checkOrientation();
          }
          
          buildCategories();
          window.scrollTo(0,1);
          $(".mail").show();
          //getSysApps();
          //setSysApps("spongebob://");
}

function executeAppDetection(){
}


if (client == "iphone"){
     //IOSNativeBridge.call('executeAppDetection');
}else if(client == "android"){
     Android.executeAppDetection();
}
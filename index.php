<?php

     /*
     example mgid requests
     9fc2b983-1bee-41d2-9381-2f7678922792
     7cb0eea8-8d8b-426f-9ad1-4aa5b91c7322
     
     59e889bb-8ca5-43fe-8392-9c925b270a21
     http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22mtvi:id|Title|Description%22:1,%22Items%22:{%22*%22:1,%22MobileApplicationReferences%22:{%22*%22:1,%22Image%22:{%22*%22:1},%22Platforms%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}}},%22MobileApplicationPlatforms%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}}}},%22where%22:{%22byId%22:[%2259e889bb-8ca5-43fe-8392-9c925b270a21%22]}}&indent=true&stage=authoring
     
     */
     $mgid = (isset($_GET['mgid'])) ? $_GET['mgid'] : "7cb0eea8-8d8b-426f-9ad1-4aa5b91c7322";
     
     $arcRequest = "http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22mtvi:id|Title|Description%22:1,%22Items%22:{%22*%22:1,%22MobileApplicationReferences%22:{%22*%22:1,%22Image%22:{%22*%22:1},%22Platforms%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}}},%22MobileApplicationPlatforms%22:{%22*%22:1,%22Images%22:{%22*%22:1,%22ImageAssetRefs%22:{%22*%22:1}}}}},%22where%22:{%22byId%22:[%22".$mgid."%22]}}&indent=true&stage=authoring";
         
     $jsonContents = file_get_contents($arcRequest);
     $jsonArray = json_decode($jsonContents,true);
     $cssURL = $jsonArray['response']['docs']['0']['Items']['0']['CssURL'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
     <head>
          <meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
          <link rel='stylesheet' type='text/css' href="<?php echo($cssURL); ?>" >
          <script type="text/javascript" src="lib/zepto.js"></script>
         <script>   
                function formValidation()
                {
                         var statusMsg = "";
                         var email = document.form1.email.value;
                         var birthday = document.form1.birthday.value;
                         console.log(birthday);
                         var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                         if(!email.match(mailformat))
                         {
                              statusMsg = "Invalid email address<br/>";
                         }
                         
                         
                         var birthdayformat =/^\d{2}\/\d{2}\/\d{2}$/; //Basic check for format validity
                         if (!birthdayformat.test(birthday)) {
                            statusMsg += "Invalid Birthday";
                         } else { 
                              var monthfield=birthday.split("/")[0];
                              var dayfield=birthday.split("/")[1];
                              var yearfield=birthday.split("/")[2];
                              dayobj = new Date(yearfield, monthfield-1, dayfield);
                              console.log(dayobj);
                              if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)) {
                                  statusMsg += "Invalid Birthday";
                              } 
                         }
                         
                         if ( statusMsg.length  ==  0 ) {
                              statusMsg = "Thank You!";
                              $("#entrystatus").addClass("success");
                              if ( $("#entrystatus").hasClass("failure") ) {
                                   $("#entrystatus").removeClass("failure");
                              }
                              $("#submitBtn").hide();
                         } else {
                              statusMsg = "<b>Email Entry Errors</b><br/>" + statusMsg;
                              if ( !$("#entrystatus").hasClass("failure")) {
                                   $("#entrystatus").addClass("failure");
                              }
                         }
                         statusMsg += "<br/>";
                         $("#entrystatus").html(statusMsg);
                }
               var rawData = <?php echo($jsonContents) ?>;  
               console.log("------ SOURCE FEED -----");
               console.log(rawData);
         </script>
         
         <script type="text/javascript" src="lib/uadetector.js"></script>
         
         <script>
         </script>
         
         <script type="text/javascript" src="lib/cstmodel.js"></script>
   
     </head>
     <body>
          <script src="http://btg.mtvnservices.com/aria/coda.html?site=mtvnmobile.mtvnservices.com" type="text/javascript"></script>
          
          <div  id="header" class="clearfix"></div>
          <!-- Carousel Component Layout -->
          <div id='slider' >
               <ul id="slider_list"> 	
               </ul>
           </div> 
          <ul id="indicator" ></ul>
          
          <h2 class="sectionHeader" id="category1"></h2>
            <!-- Grid for Cross Selling Apps Display -->
            <div id="appsGrid" class="clearfix">
            </div>
          <h2 class="sectionHeader" >Email Signup Message</h2>
               <div class="mail" >
                     
                     <form name="form1" action="#"> 
                          <ul>
                               <li><input type='text' value="enter email" name='email' initial-text="enter email" class="dataentry" /></li>
                               <li><input type='text' value="enter birthday mm/dd/yy" initial-text="enter birthday mm/dd/yy" name='birthday' class="dataentry" />
                                <li><input type='text' value="enter zipcode" initial-text="enter zipcode" name='zipcode' class="dataentry" />
                               <li/>
                               <li  class="button" id="submitBtn" onclick="formValidation()">Submit</li>
                          </ul>
                     </form>
                    
               </div>

           <div id="entrystatus"></div>
          <script src="lib/utils.js"></script>
          <script src="lib/swipe.js"></script>
          <script src="lib/cstviewcontroller.js"></script>
          <script src="lib/iosnativebridge.js"></script>
     </body>
</html>

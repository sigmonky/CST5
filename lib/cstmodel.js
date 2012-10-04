

/*function getSysApps() {
     return  cstInventory.urlSchemes();
}*/
var theStore = "unknown";    
var cstInventory =  {
          gridItems:[],
          featuredItems:{},
          gridTitle:"",
          referringApp:"",
          cssURL:"",
          emailURL:"",
          promoVidURL:"",
          linkShareURL:"",
          categoryCount:-1,
          
          parse: function( data ) {                 
               //setSysApps("spongebob://,");
               
               for ( var index = 0; index < data.length; index++ ) {
                    data[index].dataType = data[index]["mtvi:contentType"].replace("Mobile:MobileApplication","");
                    switch ( data[index].dataType ) {
                         case "Body":
                              var bodyParts = data[index];
                              this.cssURL = bodyParts.CssURL;
                              this.referringApp = bodyParts.Title;
                              this.emailURL = bodyParts.EmailSubmitURL;
                              this.promoVidURL = bodyParts.PromoVideoURL;
                              this.linkShareURL = bodyParts.LinkShareURL;
                              break;
                         case "Featured":
                              this.featuredItems = data[index].MobileApplicationReferences;
                              break;
                         case "Category":
                              this.categoryCount++;
                              this.gridItems[this.categoryCount] = {title:"",apps:[]};
                              this.gridItems[this.categoryCount].title = data[index].Title;
                              this.gridItems[this.categoryCount].apps = data[index].MobileApplicationPlatforms;
                              break;
                    }
               }
              // insertURLSchemes( this.featuredItems);
               
               this.featuredItems.indicators = {};
               this.featuredItems.indicators.off = {};
               this.featuredItems.indicators.off.url = "http://a14.akadl.mtvnservices.com/10740/cdnorigin/mobilestor/nick.com/cst/NUb_off.png";
               this.featuredItems.indicators.off.w = 17;
               this.featuredItems.indicators.off.h = 17; 
               
               this.featuredItems.indicators.on = {};
               
               this.featuredItems.indicators.on.url = '"http://a10.akadl.mtvnservices.com/10740/cdnorigin/mobilestor/nick.com/cst/NUb_on.jpg"' ;
               this.featuredItems.indicators.on.w = 17; 
               this.featuredItems.indicators.on.h =  17;
               var evt = document.createEvent("Event");
               evt.initEvent("dataReady",true,true);
               document.dispatchEvent(evt);
                
               console.log("---- PARSED FEED ----");
               console.log(this);
          },
          launchable:[],
         
          urlSchemes: function () {
               return "";
          }
     }
              

     
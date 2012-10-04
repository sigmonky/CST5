//query-string param reader utility 
function qs(key) {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    
    return (vars[key])?vars[key]:"";
}


//resize carousel on device orientaton
function didRotateTo(ori) {
     isLandscape = ( ori == "landscape");
     // trigger slider initialization      
     slider.setup();
     slider.start();
     slider.slide(0, 0); 
     if (isLandscape ){
          //slider.width = 300;	
          //slider.width = slider.container.getBoundingClientRect().width;
          slider.slide(1,0);
          //document.getElementById('slider').setAttribute('style', 'margin-left:150px');
     } else {
          //slider.width = slider.container.getBoundingClientRect().width;
          //document.getElementById('slider_list').setAttribute('style', 'margin-left:10px');
          slider.slide(0,0);
     }
     //
    
    
     //positionIndicator();

     previousOrientation = window.orientation;	
}

// deprecated
var checkOrientation = function(){
     
     if ( Math.abs(window.orientation) == 90 ) {
          isLandscape = true;
          didRotateTo("landscape");
     } else {
          isLandscape = false;
          didRotateTo("portrait");
     }
};

window.addEventListener("resize", checkOrientation, false);
window.addEventListener("orientationchange", checkOrientation, false);
window.saw = (function($){
	var wrapperTemplate = function(){
		return '<div class="slidewrap"></div>';
	}
	
	function slideTemplate(slide){
		return '<div class="slide"><div style="background-image:url('+slide.url+')"></div></div>';
	}
	
	function Lightbox (selector) {
		
		var 	container_node = $(selector), 
			wrapper, 
			chromeBuilt, 
			visibleSlide,
			
			currentSlide = -1,
			visibleSlide,
			slideData =[],
			
			boundingBox = [0,0],
			
			slideMap = {},
			
			i =0,
			 startPos, endPos, lastPos;
		
		
		function buildChrome(){
			wrapper = $(wrapperTemplate()).addClass('slidewrap');
			$('body').append(wrapper);
			boundingBox[0] = wrapper.attr('offsetWidth');
			chromeBuilt = true;
		}

		function handleClicks(e){
			e.preventDefault();
			hide();
		}

		function attachEvents(){
		     console.log("attach events");
		     console.log(wrapper.on);
			wrapper.click(function(){hide();});
		}
		
		
		function init(){
			var slides = container_node.find('li');
			var slideCount = 0;
			slides.each(function(i, el){
				var thisSlide = {}, 
				       thisImg = $(el).find('img');
				
				thisSlide.url = thisImg.attr('src').replace(/_s|_q/, '_z');
				thisSlide.height = thisImg.attr('data-full-height');
				thisSlide.width = thisImg.attr('data-full-width');
				slideData.push(thisSlide);
			});
			console.log("here are the slides");
		}
		
		function buildSlide (slideNum) {

			var thisSlide, s, img, scaleFactor = 1, w, h;
			
			if(!slideData[slideNum]){
				return false;
			} else {
			     console.log("building slide " + slideNum);
			}
			
			var thisSlide = slideData[slideNum];
			var s = $(slideTemplate(thisSlide));
			console.log(s);
			var img = s.children('div');
			
			//image is too big! scale it!
			if(thisSlide.width > boundingBox[0] || thisSlide.height > boundingBox[1]){
				
				if(thisSlide.width > thisSlide.height) {
					scaleFactor = boundingBox[0]/thisSlide.width;
				} else {
					scaleFactor = boundingBox[1]/thisSlide.height;
				}
				
				w = Math.round(thisSlide.width * scaleFactor);
				h = Math.round(thisSlide.height * scaleFactor);
				img.css('height', h + 'px');
				img.css('width', w + 'px');
				
			}else{
				img.css('height', thisSlide.height + 'px');
				img.css('width', thisSlide.width + 'px');
			}
			

			
			thisSlide.node = s;
			wrapper.append(s);
			setPosition(s, boundingBox[0]);
			console.log(slideData[slideNum]);
			return s;
		}
		
		
		function handleTouchEvents(e){
	
		}
		
		function attachTouchEvents() {
		}
		
		function prefixify(str) {
			
			var ua = window.navigator.userAgent;
			
			if(ua.indexOf('WebKit') !== -1) {
				return '-webkit-' + str;
			}
			
			if(ua.indexOf('Opera') !== -1) {
				return '-o-' + str;
			}
			
			if(ua.indexOf('Gecko') !== -1) {
				return '-moz-' + str;
			}
			
			return str;
		}
		
		function setPosition(node, left) {
			// node.css('left', left +'px');
			node.css(prefixify('transform'), "translate3d("+left+"px, 0, 0)");
		}
		
		function goTo(slideNum){
		     
			var thisSlide;
			//failure
			if(!slideData[slideNum]){
				goTo(currentSlide);
				console.log("no slide data");
				
			}  else {
			     console.log("got slide data");
			     currentSlide = slideNum;
			}
			
			thisSlide = slideData[slideNum];
			buildSlide(slideNum);
		     console.log(this.slide);
			if(thisSlide.node){
				setPosition(thisSlide.node, 0);
			}
			
		}
		
		function show(startSlide){
              $(".slide").remove();
			if(!chromeBuilt){
				buildChrome();
				attachEvents();
			}
		
			wrapper.show();
			boundingBox = [ window.innerWidth, window.innerHeight ];
               console.log("GO TO SLIDE " + startSlide);
			goTo(startSlide);
		}
		
		function hide(){
			wrapper.hide();
		}
		
		init();
		
		return {
			
			show: show,
			hide: hide
		};
		
	}
	
	return {
		Lightbox:Lightbox
	};
}($));
/*
================================================================
IMPORTS
================================================================
*/

var _ = require('underscore');

import 'lazysizes';
import 'lazysizes/plugins/unveilhooks/ls.unveilhooks';

var tm_body = document.querySelector('body');
var tm_html = document.querySelector('html');
let overlayIsOpen = false;

var Flickity = require('flickity');

import gsap from "gsap";
// import CustomEase from 'gsap/CustomEase';
import barba from '@barba/core';

import Plyr from 'plyr';


let flkty;
let players;


/*
================================================================
ARTIST LIST
================================================================
*/


class artistList extends HTMLElement {
    constructor() {
        super();
		this.artists = this.querySelectorAll('.artist-link');
		this.artistImages = Array.from(this.querySelectorAll('.image-group'));
		this.index = 0;
		this.count = 0;
		this.lastImage;
		this.init();
    }

    init(){
		for (let i = 0; i < this.artists.length; i++) {
			this.artists[i].addEventListener('mouseenter', () => {
				this.showImage(i);
			});
			this.artists[i].addEventListener('mouseout', () => {
				this.hideImages(i);
			});
			setTimeout(() => {
                show(this.artists[i]);
            }, 100 * (i+1));
			if(i % 2 == 0) {
				this.artists[i].style.transform = "rotate(" +  Math.random() * 5 + 1 + "deg)";
			}else{
				this.artists[i].style.transform = "rotate(-" +  Math.random() * 5 + 1 + "deg)";
			}
		}

		for (var i = 0; i < this.artistImages.length; i++) {
			this.artistImages[i] = Array.from(this.artistImages[i].querySelectorAll('img'));
		}

		console.log(this.artistImages);
    }


	showImage(i){
		let r = Math.floor(Math.random() * this.artistImages[i].length);
		console.log(r);
		this.artistImages[i][this.count].style.display = "block";
		this.artistImages[i][this.count].style.zIndex = this.index;
		this.index++;
		this.count++;
		if(this.count > (this.artistImages[i].length - 1)){
			this.count = 0;
		}
		console.log(this.count);
		this.lastImage = this.artistImages[i][this.count];
		// tm_body.classList.add('image-hover');
	}

	hideImages(i){
		// setTimeout(() => {
		// 	for (let r = 0; r < this.artistImages[i].length; r++) {
		// 		this.artistImages[i][r].style.display = "none";
		// 	}
		// 	// tm_body.classList.remove('image-hover');
		// }, 500);
	}

}

customElements.define('artist-list', artistList);

function show(el){
	el.classList.add('vis');
}

/*
================================================================
NAVIGATION
================================================================
*/

var toggle = document.querySelector('#menu-toggle-button');
var menu = document.querySelector('.main-menu-container');
var menuClose = document.querySelector('.menu-close');


toggle.addEventListener('click', toggleMenu);
menuClose.addEventListener('click', toggleMenu);

function toggleMenu(){
    if (menu.classList.contains('is-active')) {
        tm_body.classList.remove('menu--open');
        toggle.setAttribute('aria-expanded', 'false');
        menuClose.setAttribute('aria-expanded', 'false');
        menu.classList.remove('is-active');
    } else {
        tm_body.classList.add('menu--open');
        menu.classList.add('is-active'); 
        toggle.setAttribute('aria-expanded', 'true');
        menuClose.setAttribute('aria-expanded', 'true');
    }
}

function closeMenu(){
    tm_body.classList.remove('menu--open');
    toggle.setAttribute('aria-expanded', 'false');
    menuClose.setAttribute('aria-expanded', 'false');
    menu.classList.remove('is-active');
}

/*
================================================================
CLICKING
================================================================
*/

// Listen to all clicks on the document
document.addEventListener('click', function (event) {
	if (event.target.classList.contains('bio-link')){
		toggleBio(event.target);
		event.preventDefault();
	}
	if (event.target.classList.contains('contact-link-toggle')){
		toggleContact(event.target);
		event.preventDefault();
	}	
	if(event.target.classList.contains('album-link')){
		const url = event.target.href;
		getPage(url, "#slideshow-wrapper", "#overlay" );
		event.preventDefault();
	}
	if(event.target.classList.contains('slideshow-link')){
		let index = event.target.dataset.index;
		let vIndex = event.target.dataset.vindex;
		openSingleOverlay(Number(index), vIndex);
		event.preventDefault();
	}
	if(event.target.classList.contains('filter-button')){
		let projects = document.querySelectorAll('.album');
		let parent = event.target.parentNode;
		let otherButtons = parent.querySelectorAll('button');
		let filter = event.target.dataset.filter;
		if(event.target.classList.contains('active')){
			event.target.classList.remove('active');
			projects.forEach(element => {
				element.style.display = "block"
			})
		}else{
			otherButtons.forEach(element => {
				if(element.classList.contains('active')){
					element.classList.remove('active')
				}
			});
			event.target.classList.add('active');
			projects.forEach(element => {
				if(element.classList.contains(filter)){
					element.style.display = "block"
				}else{
					element.style.display = "none"
				}
			})
		}
	}
}, false);



/*
================================================================
OVERLAY LOADER
================================================================
*/

function getPage(url, from, to) {
	tm_body.classList.add('loading');
    var cached=sessionStorage[url];
    if(!from){from="body";} // default to grabbing body tag
    if(to && to.split){to=document.querySelector(to);} // a string TO turns into an element
    if(!to){to=document.querySelector(from);} // default re-using the source elm as the target elm
    if(cached){
		to.innerHTML=cached;
		onOverlayLoad();
		return;
	} // cache responses for instant re-use re-use

    var XHRt = new XMLHttpRequest(); // new ajax
    XHRt.responseType='document';  // ajax2 context and onload() event
    XHRt.onload = function() { 
		sessionStorage[url]=to.innerHTML= XHRt.response.querySelector(from).innerHTML;
		onOverlayLoad();
	};
    XHRt.open("GET", url, true);
    XHRt.send();
    return XHRt;
}

function onOverlayLoad () {
	let overlay = document.getElementById('overlay');
	console.log(overlay);
	initSlideshows();
	initVideos();
	openOverlay();
  }

function openOverlay(){
	let overlay = document.getElementById('overlay');
	let overlayClose = overlay.querySelector('.slideshow-close-button');
	overlay.classList.add('active');
	overlay.setAttribute('aria-hidden', 'false');
	overlayClose.addEventListener('click', closeOverlay);
	overlayClose.classList.add('prevent');
	tm_body.classList.remove('loading');
}

function closeOverlay(event){
	event.preventDefault();
	let overlay = document.getElementById('overlay');
	overlay.classList.remove('active');
	overlay.setAttribute('aria-hidden', 'true');
	stopVideos();
}

function openSingleOverlay(i, vi){
	let overlay = document.getElementById('single-overlay');
	let overlayClose = overlay.querySelector('.slideshow-close-button');
	overlay.classList.add('active');
	overlay.setAttribute('aria-hidden', 'false');
	overlayClose.focus();
	console.log(i);
	flkty.selectCell(i, false, true);
	overlayClose.addEventListener('click', closeSingleOverlay);
	overlayClose.classList.add('prevent');
	console.log(vi);
	if(vi){
		vi = Number(vi);
		players[vi].play();
	}
}

function closeSingleOverlay(event){
	event.preventDefault();
	let overlay = document.getElementById('single-overlay');
	overlay.classList.remove('active');
	overlay.setAttribute('aria-hidden', 'true');
	stopVideos();
}


/*
================================================================
BIO LINK
================================================================
*/


let bioVisible = false;

function toggleBio(target){
	let bio = document.getElementById('bio');
	let images = document.getElementById('images');
	let link = target;
	console.log(link);
	if(bioVisible){
		bio.style.display = "none";
		// images.style.display = "block";
		link.innerHTML = "Bio";
	}else{
		bio.style.display = "block";
		// images.style.display = "none";	
		link.innerHTML = "Img";
	}
	bioVisible = !bioVisible;
}

/*
================================================================
BIO LINK
================================================================
*/


let contactVisible = false;

function toggleContact(target){
	let contact = document.getElementById('contact');
	let artists = document.getElementById('artists');
	let close = contact.querySelector('.contact-link-toggle');
	if(contactVisible){
		contact.style.display = "none";
		artists.style.display = "block";
	}else{
		contact.style.display = "flex";
		artists.style.display = "none";	
	}
	contactVisible = !contactVisible;
}

/*
================================================================
ACCESSIBILITY
================================================================
*/

(function () {
    'use strict';

    function keyboardFocus (e) {
        if (e.keyCode !== 9) {
            return;
        }

        switch (e.target.nodeName.toLowerCase()) {
            case 'input':
            case 'select':
            case 'textarea':
                break;
            default:
                document.documentElement.classList.add('keyboard-focus');
                document.removeEventListener('keydown', keyboardFocus, false);
        }
    }

    document.addEventListener('keydown', keyboardFocus, false);
})();


/*
================================================================
COOKIE CONSENT
================================================================
*/
var lang = document.documentElement.lang;

var cc = initCookieConsent();

// run plugin with config object
cc.run({
	autorun : true, 
	delay : 0,
	current_lang : lang,
	auto_language : false,
	autoclear_cookies : true,
	cookie_expiration : 365,
	force_consent: false,
    gui_options: {
        consent_modal : {
            transition: 'slide'             // zoom/slide
        },
        settings_modal : {
            layout : 'bar',                 // box/bar
            // position : 'left',           // left/right
            transition: 'slide'             // zoom/slide
        }
    },
	onAccept: function(cookie){
		console.log("onAccept fired ...");
		
		if(cc.allowedCategory('analytics')){
			 
		}
        if(cc.allowedCategory('analytics')){
           
        }

		// delete line below
		typeof doDemoThings === 'function' && doDemoThings(cookie);
	},

	onChange: function(cookie){
		console.log("onChange fired ...");
		
		// delete line below
		typeof doDemoThings === 'function' && doDemoThings(cookie);
	},

	languages : {
		'en' : {	
			consent_modal : {
				title :  "Cookies",
				description :  'This site uses cookies. For more information please read our <a href="/privacy">privacy policy.</a>',
				primary_btn: {
					text: 'Accept',
					role: 'accept_all'				//'accept_selected' or 'accept_all'
				},
				secondary_btn: {
					text : 'Settings',
					role : 'settings'				//'settings' or 'accept_necessary'
				}
			},
			settings_modal : {
				title : '<div>Cookie settings</div><div aria-hidden="true" style="font-size: .8em; font-weight: 200; color: #687278; margin-top: 5px;">Powered by <a tabindex="-1" aria-hidden="true" href="https://github.com/orestbida/cookieconsent/" style="text-decoration: underline;">cookie-consent</a></div>',
				save_settings_btn : "Save settings",
				accept_all_btn : "Accept all",
				close_btn_label: "Close",
				cookie_table_headers : [
					{col1: "Name" }, 
					{col2: "Domain" }, 
					{col3: "Expiration" }, 
					{col4: "Description" }, 
					{col5: "Type" }
				],
				blocks : [
					{
						title : "Cookie usage",
						description: 'I use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="#" class="cc-link">privacy policy</a>.'
					},{
						title : "Strictly necessary cookies",
						description: 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
						toggle : {
							value : 'necessary',
							enabled : true,
							readonly: true							//cookie categories with readonly=true are all treated as "necessary cookies"
						}
					},{
						title : "Preferences cookies",
						description: 'These cookies allow the website to remember the choices you have made in the past',
						toggle : {
							value : 'preferences',	//there are no default categories => you specify them
							enabled : false,
							readonly: false
						}
					},{
						title : "Analytics cookies",
						description: 'These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you',
						toggle : {
							value : 'analytics',
							enabled : false,
							readonly: false
						},
						cookie_table: [
							{
								col1: '_ga',
								col2: 'google.com',
								col3: '2 years',
								col4: 'description ...' ,
								col5: 'Permanent cookie'
							},
							{
								col1: '_gat',
								col2: 'google.com',
								col3: '1 minute',
								col4: 'description ...' ,
								col5: 'Permanent cookie'
							},
							{
								col1: '_gid',
								col2: 'google.com',
								col3: '1 day',
								col4: 'description ...' ,
								col5: 'Permanent cookie'
							}
						]
					},{
						title : "More information",
						description: 'For any queries in relation to my policy on cookies and your choices, please <a class="cc-link" href="https://orestbida.com/contact">contact me</a>.',
					}
				]
			}
		},
        'cy' : {	
			consent_modal : {
				title :  "Welsh Cookies",
				description :  'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
				primary_btn: {
					text: 'Accept',
					role: 'accept_all'				//'accept_selected' or 'accept_all'
				},
				secondary_btn: {
					text : 'Reject',
					role : 'accept_necessary'				//'settings' or 'accept_necessary'
				}
			},
			settings_modal : {
				title : '<div>Cookie settings</div><div aria-hidden="true" style="font-size: .8em; font-weight: 200; color: #687278; margin-top: 5px;">Powered by <a tabindex="-1" aria-hidden="true" href="https://github.com/orestbida/cookieconsent/" style="text-decoration: underline;">cookie-consent</a></div>',
				save_settings_btn : "Save settings",
				accept_all_btn : "Accept all",
				close_btn_label: "Close",
				cookie_table_headers : [
					{col1: "Name" }, 
					{col2: "Domain" }, 
					{col3: "Expiration" }, 
					{col4: "Description" }, 
					{col5: "Type" }
				],
				blocks : [
					{
						title : "Cookie usage",
						description: 'I use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="#" class="cc-link">privacy policy</a>.'
					},{
						title : "Strictly necessary cookies",
						description: 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
						toggle : {
							value : 'necessary',
							enabled : true,
							readonly: true							//cookie categories with readonly=true are all treated as "necessary cookies"
						}
					},{
						title : "Preferences cookies",
						description: 'These cookies allow the website to remember the choices you have made in the past',
						toggle : {
							value : 'preferences',	//there are no default categories => you specify them
							enabled : false,
							readonly: false
						}
					},{
						title : "Analytics cookies",
						description: 'These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you',
						toggle : {
							value : 'analytics',
							enabled : false,
							readonly: false
						},
						cookie_table: [
							{
								col1: '_ga',
								col2: 'google.com',
								col3: '2 years',
								col4: 'description ...' ,
								col5: 'Permanent cookie'
							},
							{
								col1: '_gat',
								col2: 'google.com',
								col3: '1 minute',
								col4: 'description ...' ,
								col5: 'Permanent cookie'
							},
							{
								col1: '_gid',
								col2: 'google.com',
								col3: '1 day',
								col4: 'description ...' ,
								col5: 'Permanent cookie'
							}
						]
					},{
						title : "More information",
						description: 'For any queries in relation to my policy on cookies and your choices, please <a class="cc-link" href="https://orestbida.com/contact">contact me</a>.',
					}
				]
			}
		}
	}
});

/*
================================================================
SLIDESHOW
================================================================
*/

// class slideshowCompnent extends HTMLElement {
//     constructor() {
//         super();
// 		this.close = this.querySelector('.slideshow-close-button');
// 		this.count = this.querySelector('#count');
// 		this.slideshow = this.querySelector('.slideshow');
// 		this.prev = this.querySelector('.prev-slide');
// 		this.next = this.querySelector('.next-slide');
// 		this.flkty;
// 		this.init();
//     }

//     init(){
// 		this.flkty = new Flickity( this.slideshow, {
// 		// options
// 			prevNextButtons: false,
// 			pageDots: false,
// 			wrapAround: true
// 		});
// 		this.next.addEventListener('click', (event) => {
// 			// this.nextSlide(this.flkty)
// 			this.flkty.next()
// 		});
// 		this.prev.addEventListener('click', (event) => {
// 			// this.nextSlide(this.flkty)
// 			this.flkty.previous()
// 		});
// 	}

	

// }

// customElements.define('slideshow-component', slideshowCompnent);



function initSlideshows(){
	
	let slideshow = document.querySelector('.slideshow');
	let count = document.querySelector('#count');
	let prev = document.querySelector('.prev-slide');
	let next = document.querySelector('.next-slide');
	let caption = document.querySelector('.slideshow-caption-text');
	let galleryItems = document.querySelectorAll('.slideshow-link');
	if(slideshow){
		flkty = new Flickity( slideshow, {
			prevNextButtons: false,
			pageDots: false,
			wrapAround: true,
			lazyLoad: 2
		});
		next.addEventListener('click', (event) => {
			flkty.next()
		});
		prev.addEventListener('click', (event) => {
			flkty.previous()
		});
		flkty.on( 'select', function(index) {
			stopVideos();
			count.innerHTML = index + 1;
			let captionText = flkty.selectedElement.dataset.caption;
			if(caption){
				if(captionText){
					caption.innerHTML = captionText + ' – ';
				}else{
					caption.innerHTML = '';
				}
			}
		});
	}
	
}

// initSlideshows();

function initVideos(){
	
	players = Array.from(document.querySelectorAll('.js-player')).map((p) => new Plyr(p,{
		controls: ['play-large','mute'],
	}));

	// players = Plyr.setup('.js-player');

	console.log(players);

	// players.forEach(element => {
	// 	element.on('ready', (event) => {
	// 		// const player = event.detail.plyr;
	// 		console.log(players);
	// 	  });
	// });

	sizeVids();
}

// initVideos();

function stopVideos(){
	players.forEach(element => {
		// const player = element.detail.plyr;
		console.log(element);
		element.stop();
	});
}


function sizeVids(){
	const wrappers = document.querySelectorAll('.video-wrapper');
	
	wrappers.forEach(element => {
		element.style.width = "100%";
		element.style.height = "100%";
		const wrapperRatio = Math.round(element.offsetWidth / element.offsetHeight * 100) / 100;
		const vidRatio = Math.round(element.dataset.ratio * 100) / 100;
		console.log(element);
		console.log(wrapperRatio);
		console.log(vidRatio);
		if(wrapperRatio == vidRatio){
			element.style.width = "100%";
			element.style.height = "100%";
		}
		if(wrapperRatio > vidRatio){
			element.style.height = "100%";
			element.style.width = element.offsetHeight * vidRatio + "px";
		}
		if(wrapperRatio < vidRatio){
			element.style.width = "100%";
			element.style.height = element.offsetWidth / vidRatio + "px";
		}		
	});
}

function reflow(){
	sizeVids();
}

window.onresize = _.debounce(reflow, 300);

/*
================================================================
TRANSITION STUFF
================================================================
*/

function setHeight(target){
	let height = window.scrollY + window.innerHeight;
	console.log(height);
	target.style.height = height;
}

/*
================================================================
BARBA
================================================================
*/

if (history.scrollRestoration) {
    history.scrollRestoration = 'manual';
  }

const loadingMask = document.getElementById('loading-mask');

const outRight = "100%";
const outLeft = "-100%";

// CustomEase.create("ease", "0.4, 0.0, 0.2, 1");

barba.init({
	prefetchIgnore: true,
	preventRunning: true,
	timeout: 5000,
	prevent: ({ el }) => el.classList && el.classList.contains('prevent'),
    schema: {
        prefix: 'data-page',
        wrapper: 'wrapper'
    },
    views: [
		{
			namespace: 'slideshow',
			beforeEnter() {
				initSlideshows();
				initVideos();
			},
			afterEnter() {
				
			}
    	},
		{
			namespace: 'artist',
			beforeEnter() {
				initSlideshows();
				initVideos();
			},
			afterEnter() {
				
			}
    	},
		{
			namespace: 'private',
			beforeEnter() {
				initSlideshows();
				initVideos();
			},
			afterEnter() {
				
			}
    	}
	],
    transitions: [{
    name: 'down',
    sync: true,
	from: {
		custom: (data) => {
			return data.current.container.dataset.order < data.next.container.dataset.order;
		  }
	},
	leave(data) {
		return gsap.fromTo(data.current.container, {
			top: "0%"
		},{
		top: "-100vh",
		duration: .5,
		ease: "power4.inOut"
		});
	},
	enter(data) {
		return gsap.fromTo(data.next.container, {
			top: "100vh"
		},{
		top: "0%",
		duration: .5,
		ease: "power4.inOut"
		});
	}
    },
	{
		name: 'up',
		sync: true,
		from: {
			custom: (data) => {
				return data.current.container.dataset.order > data.next.container.dataset.order;
			  }
		},
		leave(data) {
			return gsap.fromTo(data.current.container, {
				top: "0%"
			},{
			top: "100vh",
			duration: .5,
			ease: "power4.inOut"
			});
		},
		enter(data) {
			return gsap.fromTo(data.next.container, {
				top: "-100vh"
			},{
			top: "0%",
			duration: .5,
			ease: "power4.inOut"
			});
		}
		}]
});

barba.hooks.beforeLeave((data) => {
	setHeight(data.current.container);
    closeMenu();
	tm_body.classList.add('in-progress');
  });

barba.hooks.beforeEnter((data) => {
	data.next.container.classList.add('in-transit');
    // jigTheLogo();
});

barba.hooks.afterEnter((data) => {
	data.next.container.classList.remove('in-transit');
	window.scrollTo(0, 0);
});

barba.hooks.after((data) => {
	tm_body.classList.remove('in-progress');
});


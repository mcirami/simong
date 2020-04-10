'use strict';

jQuery.noConflict();

var SimonG = SimonG || {};

SimonG.states = {
    footerShown: false,
    footerFixed: false,
    mobileNavShown: false,
    headerSearchVisible: false,
    isHomepage: false,
    isPDP: false,
    windowHeight: 0,
    windowWidth: 0,
    userLocation: {
        lat: (typeof sessionStorage.getItem('lat') === "string") ? sessionStorage.getItem('lat') : '',
        lng: (typeof sessionStorage.getItem('lng') === "string") ? sessionStorage.getItem('lng') : ''
    },
    iOS: /(iPad|iPhone|iPod)/g.test(navigator.userAgent),
    Android: /(Android)/g.test(navigator.userAgent)
};

var currentEnvironment = "frontEnd", //(window.location.href.indexOf("wps/")>-1)? "webSphere" : "frontEnd", //update this for whatever your current environment may be.
    visibleFooterHeight = 52;

SimonG.environment = {
    frontEnd: {
        APIEndpoints: {
            storeInfo: function() {
                return 'http://'+window.location.hostname+'/wp-content/uploads/store-locations/store-info.json';
            },
            gMapsKey: ''//'AIzaSyBcj7KjtWqqcZB1t3nGoSwN6rHwCJ4qOMk'
        },
        imagePath: 'http://'+window.location.hostname+'/wp-content/themes/simong/images/',
        picturefillPath: '/wp-content/themes/simong/js/vendor/picturefill/dist'
    },
};

SimonG.services = {
    locator: {
        getLocation: function() {
            if (Modernizr.sessionstorage && sessionStorage.getItem('lat') && sessionStorage.getItem('lng')) {
                SimonG.states.userLocation.lat = sessionStorage.getItem('lat');
                SimonG.states.userLocation.lng = sessionStorage.getItem('lng');
            }

            if (Modernizr.geolocation) { //use geolocation to get user's current location
                var get_coords = function(position) {
                    SimonG.states.userLocation.lat = position.coords.latitude;
                    SimonG.states.userLocation.lng = position.coords.longitude;
                    SimonG.services.locator.saveLocation(SimonG.states.userLocation.lat, SimonG.states.userLocation.lng, 10);
                };

                var handle_error = function(err) {
                    //user says NO to geolocation
                    if (err.code === 1) $window.trigger('geolocationDenied');
                    else $window.trigger('geolocationUnknownError');
                };
                navigator.geolocation.getCurrentPosition(get_coords, handle_error);
            }
        },
        getLatLng: function(location) { //from user's current location
            var geocoder = new google.maps.Geocoder(),
                lat,
                lng;

            geocoder.geocode({
                'address': location
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    SimonG.services.locator.saveLocation(results[0].geometry.location.A, results[0].geometry.location.F);
                } else {
                    alert("Sorry. We couldn't find that location. Please try again.");
                }
            });
        },
        saveLocation: function(lat, lng) { //save user's current location
            SimonG.states.userLocation.lat = lat;
            SimonG.states.userLocation.lng = lng;
            if (Modernizr.sessionstorage) {
                sessionStorage.setItem('lat', lat);
                sessionStorage.setItem('lng', lng);
            }
            jQuery('.no-data-msg').hide();
            $window.trigger('locationUpdated');
        },
        getRetailerData: function(lat, lng, zoom) { //get data based on user's lat/lng
            //  var retailers = (sessionStorage.getItem('retailers').length > 0) ? JSON.parse(sessionStorage.getItem('retailers')) : [];//if sessionStorage('retailers') exists and is not null, retailers = sessionStorage('retailers'), else retailers is empty array
            var retailers = [],
                storeName;
				
            var requestStoreInfo = jQuery.getJSON(SimonG.environment[currentEnvironment].APIEndpoints.storeInfo(lat, lng), function(data) {
                if (currentEnvironment === "MVC" || currentEnvironment === "webSphere") {
                    for(storeName in data) {
                        if (data.hasOwnProperty(storeName)) {
                            var thisStore = data[storeName];
                            
                            var distance = getDistanceFromLatLonInKm(thisStore.Latitude, thisStore.Longitue, lat, lng);

                            var retailer = { //storing all this so don't have to make more calls to the server
                                storeName: thisStore.StoreName,
                                partnerType: thisStore.PartnerType,
                                address: thisStore.Address,
                                city: thisStore.City,
                                state: thisStore.State,
                                zip: thisStore.PostCode,
                                lat: thisStore.Latitude,
                                lng: thisStore.Longitude,
                                // phone: thisStore.Phone,
                                distance: distance,
                                email: thisStore.Email,
                                phone: thisStore.PhoneNumber,
                                opening_hours: '',
                                directionsLink: 'https://www.google.com/maps/dir//'+ thisStore.Address + "+" + thisStore.City +"+"+ thisStore.State + "+" +thisStore.PostCode,
                                rating: '',
                                reviewsLink: '',
                                reviewsAmount: '',
                                desc: ''
                            };
                            retailers.push(retailer);
                        }
                    }
                } else {
                    for(storeName in data.simong_stores) {
                        if (data.simong_stores.hasOwnProperty(storeName)) {
                            var thisStore = data.simong_stores[storeName];
                            
                            var distance = getDistanceFromLatLonInKm(thisStore.lat, thisStore.lng, lat, lng);
                            if(distance < 50) {
	                            
	                            var website = thisStore.website;
					            if(website) {
					                if(website.toLowerCase().indexOf('www') == 0 && website.toLowerCase().indexOf('http') == 0) {
						                website = '';
					                } else if(website.toLowerCase().indexOf('http') == 0) {
						                website = 'http://'+website;
					                }
					            } else {
					                website = '';
					            }
					            
					            if(website != '') {
						            website = website.toLowerCase();
					            }

	                            var retailer = { //storing all this shit so don't have to make more calls to the server
	                                storeName: thisStore.storeName,
	                                partnerType: thisStore.partnerType,
	                                address: thisStore.address,
	                                city: thisStore.city,
	                                state: thisStore.state,
	                                zip: thisStore.zip,
	                                lat: thisStore.lat,
	                                lng: thisStore.lng,
	                                phone: thisStore.phone,
	                                distance: distance,
	                                email: thisStore.email,
	                                website: website,
	                                opening_hours: '',
	                                directionsLink: 'https://www.google.com/maps/dir/' + lat + ',' + lng + '/' + thisStore.lat + ',' + thisStore.lng,
	                                rating: '',
	                                reviewsLink: '',
	                                reviewsAmount: '',
	                                desc: ''
	                            }
	                            retailers.push(retailer);
                            }
                        }
                    }
                    
                    retailers.sort(function(a, b){
					    return parseFloat(a.distance) - parseFloat(b.distance);
					});
					
					var firstStore = null;
					if(retailers.length > 0) {
						var firstRetailer = retailers[0];
						if(firstRetailer.distance <= 5) {
							firstStore = firstRetailer;
						}
					}
					
					if(retailers.length > 6) {
						retailers = retailers.slice(0, 6);
					}
					
					retailers.sort(function(a, b){
						if(a == firstStore) {
							return -1;
						} else if(b == firstStore) {
							return 1;
						} else {
					    	return a.partnerType.localeCompare(b.partnerType);
					    }
					});
                }

                //save the data now that we've got it (so we don't have to get it on every page refresh)
                sessionStorage.setItem('retailers', JSON.stringify(retailers));

                $window.trigger('retailersUpdated');
            });
        },

        init: function() {
            if (typeof SimonG.states.userLocation.lat !== "string" || typeof SimonG.states.userLocation.lng !== "string" || !SimonG.states.userLocation.lat.length || !SimonG.states.userLocation.lng) SimonG.services.locator.getLocation();
            
            //SimonG.services.locator.getLocation();

            $window.on('locationUpdated', function() {
                SimonG.services.locator.getRetailerData(SimonG.states.userLocation.lat, SimonG.states.userLocation.lng, 10);
            });

            $window.on('geolocationUnknownError', function() {
                //silently fail, no alert
            });
        }
    },
};

SimonG.helpers = {
    disabledLinks: function() {
        jQuery('a[disabled]').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
    },
    formatCurrency: function(amountToFormat)
    {
        return "$"+amountToFormat.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    },
    scrolling: {
        allow: function(timeoutLength) {
            var time = (typeof timeoutLength !== "undefined") ? timeoutLength : 0;
            setTimeout(function() {
                jQuery('body,html').removeClass('noscroll');
            }, time);
        },
        disallow: function(timeoutLength) {
            var time = (typeof timeoutLength !== "undefined") ? timeoutLength : 200;
            setTimeout(function() {
                jQuery('body,html').addClass('noscroll');
            }, time);
        },
        preventHorizontalAndroidScroll: function() {
            if (Modernizr.touch && !SimonG.states.iOS) {
                $window.on('touchstart touchend', function() {
                    if (window.scrollLeft !== 0) $window.scrollLeft(0);
                });
            }
        }
    },
    checkOrientationChangeSupport: function() {
        if (!Modernizr.hasEvent('orientationchange')) jQuery('html').addClass('no-orientationchange');
    },
    windowWatchers: {
        pageIsAtBottom: function() { //this checks to see if the page is near the bottom, minus the height of the visible sliver of the fixed footer
            return jQuery(document).scrollTop() > (jQuery(document).height() - SimonG.states.windowHeight - ($footer.height() - visibleFooterHeight));
        },
        pageIsScrollable: function() {
            return jQuery(document).height() > SimonG.states.windowHeight;
        },
        pageIsSmallLayout: function() { //checks the visibility of a small-layout-only item
            return (jQuery('header .menu.button').is(':visible'));
        },
        pageIsLargestLayout: function() { //measures the width of the main container tag to see if we've hit our maximum allowed width
            return Modernizr.mq('screen and (min-width: 82.75em)');
        },
        windowScrollTop: function() { //cross-browser check for scroll distance between current window view and top of page
            return (typeof window.scrollY === "undefined" || window.scrollY === 0) ? ((typeof document.documentElement.scrollTop === "undefined") ? document.body.scrollTop : document.documentElement.scrollTop) : window.scrollY;
        },
        updateWindowDimensions: function() {
            SimonG.states.windowHeight = $window.height(),
            SimonG.states.windowWidth = $window.width();
            
            $window.trigger('simonGResize');
        }
    },
    lazyLoadImages: function() {
        jQuery.each(jQuery('[data-srcset]'), function() {
            if (SimonG.helpers.checkIfVisible(jQuery(this)) && !jQuery(this).is('[data-loaded]')) {
                jQuery(this).attr('srcset', jQuery.trim(jQuery(this).attr('data-srcset'))).attr('data-loaded',true);
                jQuery(this).removeAttr('data-srcset');
                
                picturefill({
                    elements: [jQuery(this)[0]],
                    reevaluate: true
                });
            }
        });
    },
    checkIfVisible: function($obj) {

        var vpH = jQuery(window).height(), // Viewport Height
            st = SimonG.helpers.windowWatchers.windowScrollTop(), // Scroll Top
            y = $obj.offset().top, // Element offset from top
            lh = (vpH / 2); //-(vpH / 4); // Look-ahead offset

        return (y < (vpH + st + lh));
    },
    polyfills: {
        placeholders: {
            init: function() {
                if (!Modernizr.input.placeholder) {
                    jQuery('[placeholder]').focus(function() { //Thanks to: http://webdesignerwall.com/tutorials/cross-browser-html5-placeholder-text & http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
                        var input = jQuery(this);
                        if (input.val() === input.attr('placeholder')) {
                            input.val('');
                            input.removeClass('placeholder');
                        }
                    }).blur(function() {
                        var input = jQuery(this);
                        if (input.val() === '' || input.val() === input.attr('placeholder')) {
                            input.addClass('placeholder');
                            input.val(input.attr('placeholder'));
                        }
                    }).blur();

                    jQuery('[placeholder]').parents('form').submit(function() {
                        jQuery(this).find('[placeholder]').each(function() {
                            var input = jQuery(this);
                            if (input.val() === input.attr('placeholder')) input.val('');
                        });
                    });
                }
            }
        }
    },
    formValidate: function(form_name){
        var fields = jQuery("#" + form_name).find("select[required], textarea[required], input[required], input[name=email]").serializeArray();
        var trigger = 0;
        var msg ='';

        jQuery.each(fields, function(i, field) {
            if (!field.value){
                msg += field.name + ' is required\n';
                trigger = 1;
            }
        }); 
        var emailAddy = jQuery("#" + form_name).find("input[name=email]");
        if(emailAddy.length>0)
        {
            var filter= /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if(!filter.test(emailAddy[0].value))
            {
                msg += emailAddy[0].name + ' is invalid\n';
                trigger=1;
            }
        }
        var emailMatches = jQuery("#" + form_name).find("input[name=email2]");
        if(emailMatches.length>0){
            if(emailAddy[0].value != emailMatches[0].value)
            {
                msg += emailAddy[0].name + ' and ' + emailMatches[0].name + ' do not match\n';
                trigger=1;
            }    
        }
        if(trigger){
            alert(msg);
            return false;
        }else{
            return true;
        }
    }
};

SimonG.widgets = {
    whereToBuy: {
        map: null,
        infoWindows: [],
        markers: [],
        retailers: {},
        
        createInfoWindows: function(marker, retailer) {
            var markerContent;
            if(retailer.website != '') { 
            	markerContent = '<div class="marker-content">\n' +
	                '<h2>' + retailer.storeName + '</h2>\n' +
	                '<p itemprop="address">\n' +
	                '<span itemprop="street-address">' + retailer.address + '</span>\n' +
	                '<span itemprop="locality">' + retailer.city + '</span>, <span itemprop="region">' + retailer.state + '</span> <span itemprop="postal-code">' + retailer.zip + '</span>\n' +
	                '</p>\n' +
	                '<a href="tel:+' + retailer.phone + '" itemprop="tel">' + retailer.phone + '</a>\n' +
	                '<p class="location"><span>' + retailer.distance + ' mi</span> | <a href="' + retailer.directionsLink + '">Get Directions</a></p>\n' +
	                '<a class="website" href="http://' + retailer.website + '" target="_blank">' + retailer.website + '</a>\n' +
	                '</div>';
            } else {
	            markerContent = '<div class="marker-content">\n' +
	                '<h2>' + retailer.storeName + '</h2>\n' +
	                '<p itemprop="address">\n' +
	                '<span itemprop="street-address">' + retailer.address + '</span>\n' +
	                '<span itemprop="locality">' + retailer.city + '</span>, <span itemprop="region">' + retailer.state + '</span> <span itemprop="postal-code">' + retailer.zip + '</span>\n' +
	                '</p>\n' +
	                '<a href="tel:+' + retailer.phone + '" itemprop="tel">' + retailer.phone + '</a>\n' +
	                '<p class="location"><span>' + retailer.distance + ' mi</span> | <a href="' + retailer.directionsLink + '">Get Directions</a></p>\n' +
	                '</div>';
            }
            
            var infowindow = new google.maps.InfoWindow({
                    content: markerContent
                });

            //when click icon, open info window
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(SimonG.widgets.whereToBuy.map, marker);
            });

            SimonG.widgets.whereToBuy.infoWindows.push(infowindow);
        },
        setStoreInfo: function() {
            //first, clear what's already there (in case user changes location)
            jQuery('#store-info').empty(); //Where to Buy page left sidebar

            //for each marker, append this code block w/populated JSON
            jQuery.each(SimonG.widgets.whereToBuy.retailers, function(i) {
                var partnerTypeHTML,
                    description;

                if (this.partnerType === "A") partnerTypeHTML = "<p>Diamond Jeweler Partner</p>";
                else if (this.partnerType === "B") partnerTypeHTML = "<p>Sapphire Jeweler Partner</p>";
                else if (this.partnerType === "C") partnerTypeHTML = "<p>Emerald Jeweler Partner</p>";
                else if (this.partnerType === "D") partnerTypeHTML = "<p>Authorized Jeweler Partner</p>";
                else partnerTypeHTML = "";

                if (this.desc === "") description = '';
                else description = '<p class="desc">' + this.desc + '</p>';
                var phone= (this.phone==null)? '':'<a href="tel:+' + this.phone.replace('/', ' ') + '" itemprop="tel">' + this.phone.replace('/', ' ') + '</a>\n';
                
                var website = this.website;
                //add info to left sidebar
                if(website != '') {
	                jQuery('#store-info').append('<div class="store_result_wrap">\n' + '<div class="store" data-store="' + i + '" data-partner="' + this.partnerType + '">\n' +
	                    '<hgroup>\n' + partnerTypeHTML +
	                    '<h2>' + this.storeName + '</h2>\n' +
	                    '</hgroup>\n' +
	                    '<p itemprop="address">\n' +
	                    '<span itemprop="street-address">' + this.address + '</span>\n' +
	                    '<span itemprop="locality">' + this.city + '</span>, <span itemprop="region">' + this.state + '</span> <span itemprop="postal-code">' + this.zip + '</span>\n' +
	                    '</p>\n' +
	                    phone +
	                    '<p class="location"><span>' + this.distance + ' mi</span> | <a href="' + this.directionsLink + '">Get Directions</a></p>\n' +
	                    '<a class="website" href="http://' + website + '" target="_blank">' + website + '</a>\n' +
	                    description +
	                    '</div>\n' + '</div>');
                } else {
	                jQuery('#store-info').append('<div class="store_result_wrap">\n' + '<div class="store" data-store="' + i + '" data-partner="' + this.partnerType + '">\n' +
	                    '<hgroup>\n' + partnerTypeHTML +
	                    '<h2>' + this.storeName + '</h2>\n' +
	                    '</hgroup>\n' +
	                    '<p itemprop="address">\n' +
	                    '<span itemprop="street-address">' + this.address + '</span>\n' +
	                    '<span itemprop="locality">' + this.city + '</span>, <span itemprop="region">' + this.state + '</span> <span itemprop="postal-code">' + this.zip + '</span>\n' +
	                    '</p>\n' +
	                    phone +
	                    '<p class="location"><span>' + this.distance + ' mi</span> | <a href="' + this.directionsLink + '">Get Directions</a></p>\n' +
	                    description +
	                    '</div>\n' + '</div>');
                }
            });

            var store = jQuery('.store');

            store.click(function() {
                jQuery.each(SimonG.widgets.whereToBuy.infoWindows, function(i) {
                    SimonG.widgets.whereToBuy.infoWindows[i].close();
                });

                var thisStoreNumber = jQuery(this).attr('data-store');

                SimonG.widgets.whereToBuy.infoWindows[thisStoreNumber].open(SimonG.widgets.whereToBuy.map, SimonG.widgets.whereToBuy.markers[thisStoreNumber]);
            });
        },
        createMap: function(lat, lng, zoom) {
            var mapOptions = {
                center: new google.maps.LatLng(lat, lng),
                zoom: zoom
            };
            SimonG.widgets.whereToBuy.map = new google.maps.Map($map[0], mapOptions);

            google.maps.event.addListenerOnce(SimonG.widgets.whereToBuy.map, 'idle', function(){
                $window.trigger('mapCreated');
            });
        },
        createMarkers: function() {
            SimonG.widgets.whereToBuy.markers = [];
            var markerBounds = new google.maps.LatLngBounds();

            //add each marker to map
            jQuery.each(SimonG.widgets.whereToBuy.retailers, function() {
                var image;

                if (this.partnerType === "A") {
                    image = SimonG.environment[currentEnvironment].imagePath + "map/diamond.png";
                } else if (this.partnerType === "B") {
                    image = SimonG.environment[currentEnvironment].imagePath + "map/sapphire.png";
                } else if (this.partnerType === "C") {
                    image = SimonG.environment[currentEnvironment].imagePath + "map/emerald.png";
                } else if (this.partnerType === "D") {
                    image = SimonG.environment[currentEnvironment].imagePath + "map/authorized.png";
                } else {
                    image = SimonG.environment[currentEnvironment].imagePath + "map/store.png";
                }

                var _params = {
                    radius: 100000,
                    name: this.storeName,
                    location: {
                        "lat": this.lat,
                        "lng": this.lng
                    },
                    key: SimonG.environment[currentEnvironment].APIEndpoints.gMapsKey
                };

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(this.lat, this.lng),
                    map: SimonG.widgets.whereToBuy.map,
                    icon: image,
                    title: this.storeName
                });

                var point = new google.maps.LatLng(this.lat, this.lng);
                markerBounds.extend(point);

                SimonG.widgets.whereToBuy.markers.push(marker);
                SimonG.widgets.whereToBuy.createInfoWindows(marker, this);
            });
            SimonG.widgets.whereToBuy.map.fitBounds(markerBounds);
        },
        populate: function(){
           SimonG.widgets.whereToBuy.retailers = JSON.parse(sessionStorage.getItem('retailers'));
           if (SimonG.widgets.whereToBuy.retailers !== null && SimonG.widgets.whereToBuy.retailers.length) { //if have retailers
                SimonG.widgets.whereToBuy.createMarkers();
                SimonG.widgets.whereToBuy.setStoreInfo();
           }      
        },
        clearMarkers: function() {
            jQuery.each(SimonG.widgets.whereToBuy.markers, function() {
                this.setMap(null);
            });
            SimonG.widgets.whereToBuy.infoWindows = SimonG.widgets.whereToBuy.markers = [];
        },
        createPlaceholderMap: function() {
            SimonG.widgets.whereToBuy.createMap(39.50, -98.35, 4, null); //load map w/default position (centered on USA)
        },
        init: function() {
            $map = jQuery('#map');
            if ($map.length) {
                if (typeof SimonG.states.userLocation.lat !== "string" || typeof SimonG.states.userLocation.lat !== "string") SimonG.widgets.whereToBuy.createPlaceholderMap();
                else SimonG.widgets.whereToBuy.createMap(SimonG.states.userLocation.lat, SimonG.states.userLocation.lng, 10);

                $window.on('retailersUpdated', function() {
                    SimonG.widgets.whereToBuy.clearMarkers();
                });

                $window.on('geolocationDenied retailersUpdated mapCreated', function() {
                   SimonG.widgets.whereToBuy.populate();
                });
            }
        }
    },
    locatorBanner: {
        init: function() {
            var $locatorBanner = jQuery('.banner-locator');
            if ($locatorBanner.length) {
                $locatorBanner.find('form').on('submit', function(e) { //bind to all locator banners
                    e.preventDefault();
                    //pass to Geocoding API to get lat/long from val
                    SimonG.services.locator.getLatLng(jQuery(this).find('input[type=text]').val());
                });
            }
        }
    },
    /*mobileNav: {
        reveal: function() {
            $mobileNav.css('left', 0);
            $mobileNavToggle.addClass('shown');
            SimonG.states.mobileNavShown = true;
            SimonG.helpers.scrolling.disallow(250);
        },
        hide: function() {
            $mobileNav.css('left', '-999px');
            $mobileNavToggle.removeClass('shown');
            SimonG.states.mobileNavShown = false;
            SimonG.helpers.scrolling.allow();
        },
        init: function() {
            $mobileNav = jQuery('.mobile-nav'), $mobileNavToggle = jQuery('header a.menu, .mobile-nav a.close');
            if (typeof $mobileNavToggle !== "undefined") {
                $mobileNavToggle.on('click', function(e) {
                    e.preventDefault();
                    if (SimonG.states.footerShown) SimonG.widgets.footer.slideDownFixedFooter();
                    if (!SimonG.states.mobileNavShown) SimonG.widgets.mobileNav.reveal();
                    else SimonG.widgets.mobileNav.hide();
                });
            }
            $window.on('simonGResize.mobileNav', function() {
                if (SimonG.states.mobileNavShown === true && !SimonG.helpers.windowWatchers.pageIsSmallLayout()) SimonG.widgets.mobileNav.hide();
            });
        }
    },*/
    footer: {
        visibleSlice: 52, //height (in pixels) of the visible slice of the fixed footer
        fix: function() {
            if (!SimonG.states.isAppleOrAndroid) SimonG.widgets.footer.addBodyPadding();

            jQuery('body').addClass('fixed-footer');

            $footer.css('bottom', -($footer.height() - visibleFooterHeight)).addClass('fixed');

            $footerToggle.css('opacity', '1').removeClass('down');

            clearTimeout(SimonG.widgets.footer.scrollTimeout);

            SimonG.widgets.footer.scrollTimeout = setTimeout(function() {
                SimonG.states.footerFixed = true;
            }, 20);

            SimonG.states.footerShown = false;

            if (SimonG.states.isHomepage) SimonG.widgets.homeMarquee.adjustWidgetWrapperHeight();
        },
        unfix: function() {
            SimonG.widgets.footer.removeBodyPadding();
            $footer.css('bottom', 0).removeClass('fixed');
            $footerToggle.css('opacity', '0');
            SimonG.states.footerFixed = false;
            jQuery('body').removeClass('fixed-footer');
            if (SimonG.states.isHomepage) SimonG.widgets.homeMarquee.adjustWidgetWrapperHeight();
        },
        addBodyPadding: function() {
            jQuery('[role=main]').css('padding-bottom', $footer.height());
        },
        removeBodyPadding: function() {
            jQuery('[role=main]').css('padding-bottom', '0');
        },
        slideUpFixedFooter: function() {
            if ($footer.hasClass('fixed')) {
                var offset = 0;
                if ($footer.height() > SimonG.states.windowHeight) offset = (SimonG.states.windowHeight - $footer.height());

                $footer.stop().animate({
                    'bottom': offset
                }, 300);

                $footerToggle.addClass('down');
                SimonG.states.footerShown = true;
            }
        },
        slideDownFixedFooter: function() {
            if ($footer.hasClass('fixed')) {
                $footer.stop().animate({
                    'bottom': -($footer.height() - visibleFooterHeight)
                }, 300);

                $footerToggle.removeClass('down');
                SimonG.states.footerShown = false;

                if ($footer.height() > SimonG.states.windowHeight && SimonG.helpers.windowWatchers.pageIsScrollable()) $window.scrollTop(0);
            }
        },
        check: function() {
            var footerHeight = $footer.height();
            if (SimonG.states.windowHeight < footerHeight) SimonG.widgets.footer.unfix();
            else if (SimonG.states.isAppleOrAndroid) SimonG.widgets.footer.fix();
            else {
                if (SimonG.states.footerShown === true) SimonG.widgets.footer.fix();
                else if (SimonG.helpers.windowWatchers.pageIsScrollable()) {
                    if (SimonG.helpers.windowWatchers.pageIsAtBottom()) SimonG.widgets.footer.unfix();
                    else SimonG.widgets.footer.fix();
                } else if (jQuery('body').outerHeight() < SimonG.states.windowHeight) SimonG.widgets.footer.fix();
                else SimonG.widgets.footer.unfix();
            }
        },
        buildRetailerList: function() {
            jQuery('.footer_form .partners').empty(); //first, clear what's already there (in case user changes location)

            if (Modernizr.sessionstorage) {
                var retailers = (sessionStorage.getItem('retailers') !== null) ? JSON.parse(sessionStorage.getItem('retailers')) : []; //if sessionStorage('retailers') exists and is not null, markers = sessionStorage('markers'), else markers is empty array
                if (retailers.length) {
                    //for each retailer, append this code block w/populated JSON
                    jQuery.each([retailers[1], retailers[2], retailers[3]], function(i) { //only 1st 3 retailers
                        var partnerTypeHTML,
                            description;

                        if (retailers[i].partnerType === "A") {
                            partnerTypeHTML = '<p class="diamond_jeweler">Diamond Jeweler Partner</p>';
                        } else if (retailers[i].partnerType === "B") {
                            partnerTypeHTML = '<p class="sapphire_jeweler">Sapphire Jeweler Partner</p>';
                        } else if (retailers[i].partnerType === "C") {
                            partnerTypeHTML = '<p class="emerald_jeweler">Emerald Jeweler Partner</p>';
                        } else if (retailers[i].partnerType === "D") {
                            partnerTypeHTML = '<p class="authorized_jeweler">Authorized Jeweler Partner</p>';
                        } else {
                            partnerTypeHTML = "";
                        }
                        
                        var website = retailers[i].website;
						//add info to footer
						if(website != '') {
	                        jQuery('.footer_form .partners').append('<li data-partner="' + retailers[i].partnerType + '">\n' +
	                        	partnerTypeHTML+
		                        '<div class="address">'+
		                        '<h5>' + retailers[i].storeName + '</h5>'+
		                        '<p>' + retailers[i].address + '</p>'+
		                        '<p>' + retailers[i].city + ',' + retailers[i].state + ' ' + retailers[i].zip + '</p>'+
		                        '<a href="tel+:' + retailers[i].phone + '">' + retailers[i].phone + '</a>'+
		                        '<a href="' + retailers[i].directionsLink + '" target="_blank">Get directions</a>'+
		                        '<p class="distance">' + retailers[i].distance + ' miles away</p>'+
		                        '<a class="website" href="http://' + website + '" target="_blank">' + website + '</a>\n' +
		                        '</div>'+
		                        '</li>');
	                    } else {
		                    jQuery('.footer_form .partners').append('<li data-partner="' + retailers[i].partnerType + '">\n' +
	                        	partnerTypeHTML+
		                        '<div class="address">'+
		                        '<h5>' + retailers[i].storeName + '</h5>'+
		                        '<p>' + retailers[i].address + '</p>'+
		                        '<p>' + retailers[i].city + ',' + retailers[i].state + ' ' + retailers[i].zip + '</p>'+
		                        '<a href="tel+:' + retailers[i].phone + '">' + retailers[i].phone + '</a>'+
		                        '<a href="' + retailers[i].directionsLink + '" target="_blank">Get directions</a>'+
		                        '<p class="distance">' + retailers[i].distance + ' miles away</p>'+
		                        '</div>'+
		                        '</li>');
	                    }
	                        
	                        /*'<hgroup>\n' + partnerTypeHTML +
                            '<h5>' + retailers[i].storeName + '</h5>\n' +
                            '</hgroup>\n' +
                            '<div class="details">\n' +
                            '<p itemprop="address">\n' +
                            '<span itemprop="street-address">' + retailers[i].address + '</span>\n' +
                            '<span itemprop="locality">' + retailers[i].city + '</span>, <span itemprop="">' + retailers[i].state + '</span> <span itemprop="">' + retailers[i].zip + '</span>\n' +
                            '</p>\n' +
                            '<a href="tel:+' + retailers[i].phone + '" itemprop="tel">' + retailers[i].phone + '</a>\n' +
                            '<ul>\n' +
                            '<li><a href="tel:+' + retailers[i].phone + '" itemprop="tel">' + retailers[i].phone + '</a></li>\n' +
                            '<li><a href="' + retailers[i].directionsLink + '" target="_blank">Get directions</a></li>\n' +
                            '</ul>\n' +
                            '<p class="distance">' + retailers[i].distance + ' miles away</p>\n' +
                            '</div>\n' +
                            '</li>'*/
                    });
                    SimonG.widgets.footer.check();
                }
            }
        },
        preventDefaultInteraction: function(e) {
            var target = jQuery(e.target);
            if ((target.is('a') && !target.hasClass('arrow'))); // do nothing
            else if (target.is('input')) target.focus();
            else (SimonG.states.footerShown === true) ? SimonG.widgets.footer.slideDownFixedFooter() : SimonG.widgets.footer.slideUpFixedFooter();
        },
        init: function() {
            $footer = jQuery('.footer_form'),
            $footerLocationForm = $footer.find('.location-search'),
            $footerToggle = $footer.find('.arrow'); //jquery objects/elements associated with the footer

            SimonG.widgets.footer.buildRetailerList();
            setTimeout(function(){
                 SimonG.widgets.footer.check();
             },200);
            if (!SimonG.states.isAppleOrAndroid) {
                $window.on('scroll.footer', function() {
                    if (jQuery('body:animated').length < 1) {
                        SimonG.widgets.footer.check();
                    }
                });
            }

            $window.on('retailersUpdated', function() {
                SimonG.widgets.footer.buildRetailerList();
            });

            $window.on('simonGResize.footer orientationchange.footer', function() {
                SimonG.widgets.footer.check();
            });

            $footerLocationForm.on('submit', function(e) {
                e.preventDefault();
                SimonG.services.locator.getLatLng(jQuery(this).find('input[type=text]').val());
            });

            if (SimonG.states.isAppleOrAndroid) {
                SimonG.widgets.footer.fix();
                $footer.on('touchstart.footer', function(e) {
                    // e.preventDefault();
                    SimonG.widgets.footer.preventDefaultInteraction(e);
                });
            } else {
                $footer.on('click.footer', function(e) {
                    SimonG.widgets.footer.preventDefaultInteraction(e);
                });
                SimonG.widgets.footer.check();
            }
        },
        timeout: {},
        scrollTimeout: {}
    },
    
    contactRetailer: {
        updateRetailerList: function() {
            var retailers = (sessionStorage.getItem('retailers') !== null) ? JSON.parse(sessionStorage.getItem('retailers')) : [],
                retailerList = $retailerContact.find('.retailers');

            if (retailers.length) {
                retailerList.empty();
                
                if (retailers.length > 4) retailers = retailers.slice(0, 4); //trim the list to the first 4

                jQuery.each(retailers, function(i) {
                    var retailer = this,
                                        //(this.partnerType === "A") ? 'diamond' : (this.partnerType === "B") ? 'sapphire': '',
                        retailerStatus = (this.partnerType === "A") ? 'diamond' : (this.partnerType === "B") ? 'sapphire': (this.partnerType === "C") ? 'emerald' : (this.partnerType === "D") ? 'authorized' : '',
                        statusTitle = (retailerStatus.length > 0) ? retailerStatus + ' Jeweler Partner' : '',
                        retailHTML = '<div class="retailer">';
                        retailHTML += '<div class="details">',
                        retailHTML += '<input type="radio" id="retailer' + i + '" name="retailer" value="' + retailer.email + '" required>',
                        retailHTML += '<div class="contact_retailer_info"><label for="retailer' + i + '"><span class="' + retailerStatus + ' partner">' + statusTitle + '</span>' + retailer.storeName + '</label>',
                        retailHTML += '<h5>' + retailer.address + '<br>',
                        retailHTML += retailer.city + ', ' + retailer.state + ' ' + retailer.zip + '<br>',
                        retailHTML += '<a href="' + retailer.phone + '" class="phone">' + retailer.phone + '</a>',
                        retailHTML += '</h5>',
                        retailHTML += '<ul>',
                        retailHTML += '<li><a href="' + retailer.directionsLink + '">' + retailer.distance + '</a></li>',
                        retailHTML += '<li><a href="' + retailer.directionsLink + '">Get directions</a></li>',
                        retailHTML += '</ul></div></div></div>'
                    retailerList.append(retailHTML);
                });

                $window.trigger('contactRetailerFormReady');
            } 
            else retailerList.text("Search for a retail partner in your area using the form above.");
        },
        bindRetailerSelection: function() {
            $retailerContactList = $retailerContact.find('[type=radio]');
            //$retailerContactList.off('change.contactRetailer');

            $retailerContactList.on('change.contactRetailer', function() {
                SimonG.widgets.contactRetailer.updateSelectedRetailer();
            });
        },
        updateSelectedRetailer: function() {
            $retailerContactList.parents('.retailer').removeClass('selected');
            
            jQuery.each($retailerContactList, function() {
                if (jQuery(this).is(':checked')) {
                	jQuery(this).parents('.retailer').addClass('selected');
                	var checkedEmail = jQuery(this).val();
                	jQuery('#input_4_8').attr('value', checkedEmail);
                }
            });
        },
        submitToHubSpot: function() {
            var retailers = $retailerContact.find("input[name=retailer]:checked").val();
            var retailerInfo = retailers.split("::");
            $retailerContact.append("<input type='hidden' name='retailer_name' value='" + retailerInfo[1] + "' />");
            $retailerContact.append("<input type='hidden' name='retailer_address' value='" + retailerInfo[2] + "' />");
            $retailerContact.append("<input type='hidden' name='retailer_email' value='" + retailerInfo[0] + "' />");
            var formData = $retailerContact.serialize();
            jQuery.ajax({
                url: "https://forms.hubspot.com/uploads/form/v2/371277/07fdc898-2288-49b5-802c-391be33cf5b0",
                type: "POST",
                data: formData,
                dataType: "text",
                success: function(data, textStatus, jqXHR) {

                },  
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        },
        submitToWebSphere: function(){
            if ($retailerContact.find("input[name=retailer]:checked").length > 0){
                var formArray = $retailerContact.serializeArray(),
                    retailerInfo = formArray[0].value.split("::");
                    formArray[0].value = encodeURIComponent(retailerInfo[1]);  //Put name of retailer in the "retailer" spot
                var emailTo = (window.location.href.search('dev-')>-1)? 'lindsay.avery@glg.com' : (window.location.href.search('s1-')>-1)? 'testglg@yahoo.com,testglg@live.com,testglgs@gmail.com': retailerInfo[0];
                formArray.push({name: "retailerEmail", value: retailerInfo[0]},{name: "retailerAddress", value: retailerInfo[2]},{name: "retailerCityStateZip", value: retailerInfo[3]},{name: "retailerPhone", value: retailerInfo[4]});
                var emailInfo = {
                    uuid : window.location.search.slice(1).replace("uuid=", ""),
                    //emailto : retailerInfo[0] + ', info@simongjewelry.com,' + formArray[4].value,
                    emailto: emailTo,
                    subject : "Simon G. Contact a Retailer",
                    cmpnt : "HTML-Contact A Retailer-To Retailer"
                }
                
                jQuery.ajax({
                    url: SimonG.environment.webSphere.APIEndpoints.emailSender(emailInfo, formArray),
                    type: "GET",
                    success: function(){
                        jQuery(".contact-information").html("<h2>Thank you for contacting your local retailer.</h2><p>Thank you for your interest in Simon G. Jewelry. We will respond to your email shortly.</p>");
                    },
                    error: function(){
                        jQuery(".contact-information").html("<h2>Sorry, there was an error</h2><p>Please try again.</p>");
                    }
                });
                emailTo = (window.location.href.search('dev-')>-1)? 'lindsay.avery@glg.com' : (window.location.href.search('s1-')>-1)? 'testglg@yahoo.com,testglg@live.com,testglgs@gmail.com': 'info@simongjewelry.com';
                var emailInfo = {
                    uuid : window.location.search.slice(1).replace("uuid=", ""),
                    //emailto : retailerInfo[0] + ', info@simongjewelry.com,' + formArray[4].value,
                    emailto: emailTo,
                    subject : "Simon G. Contact a Retailer",
                    cmpnt : "HTML-Contact A Retailer-To Simon G"
                }
                
                jQuery.ajax({
                    url: SimonG.environment.webSphere.APIEndpoints.emailSender(emailInfo, formArray),
                    type: "GET",
                    success: function(){
                        jQuery(".contact-information").html("<h2>Thank you for contacting your local retailer.</h2><p>Thank you for your interest in Simon G. Jewelry. We will respond to your email shortly.</p>");
                    },
                    error: function(){
                        jQuery(".contact-information").html("<h2>Sorry, there was an error</h2><p>Please try again.</p>");
                    }
                });
                 emailTo = (window.location.href.search('dev-')>-1)? 'lindsay.avery@glg.com' : (window.location.href.search('s1-')>-1)? 'testglg@yahoo.com,testglg@live.com,testglgs@gmail.com': formArray[4].value;
                 var emailInfo = {
                    uuid : window.location.search.slice(1).replace("uuid=", ""),
                    //emailto : retailerInfo[0] + ', info@simongjewelry.com,' + formArray[4].value,
                    emailto: emailTo,
                    subject : "Simon G. Contact a Retailer",
                    cmpnt : "HTML-Contact A Retailer-To Customer"
                }
                
                jQuery.ajax({
                    url: SimonG.environment.webSphere.APIEndpoints.emailSender(emailInfo, formArray),
                    type: "GET",
                    success: function(){
                        jQuery(".contact-information").html("<h2>Thank you for contacting your local retailer.</h2><p>Thank you for your interest in Simon G. Jewelry. We will respond to your email shortly.</p>");
                    },
                    error: function(){
                        jQuery(".contact-information").html("<h2>Sorry, there was an error</h2><p>Please try again.</p>");
                    }
                });
            }else{
                alert("You must search for and select a retail partner in your area using the section above.");
            }
        },
        init: function() {
            $retailerContact = jQuery('#contact-retailer');

            if ($retailerContact.length) {
                SimonG.widgets.contactRetailer.updateRetailerList();
                SimonG.widgets.contactRetailer.bindRetailerSelection();

                $window.on('retailersUpdated', function() {
                    SimonG.widgets.contactRetailer.updateRetailerList();
                });
                $window.on('contactRetailerFormReady', function() {
                    SimonG.widgets.contactRetailer.bindRetailerSelection();
                    SimonG.widgets.customRadioButton.bindInteraction();
                });
                $retailerContact.find("input[type=submit]").bind("click", function(e) {
                    e.preventDefault();

                    if(SimonG.helpers.formValidate('contact-retailer')){
                        if ($retailerContact.find('label[for=offers]').is('.checked')){
                            SimonG.widgets.contactRetailer.submitToHubSpot();
                        }
                        SimonG.widgets.contactRetailer.submitToWebSphere();
                    }
                });
            }
        }
    },
};

SimonG.init = function() {
    var lazyLoadTimeout = {};
    $window = jQuery(window);
    //SimonG.states.isAppleOrAndroid = (SimonG.states.iOS || SimonG.states.Android);
    //SimonG.helpers.scrolling.preventHorizontalAndroidScroll();
    //SimonG.helpers.checkOrientationChangeSupport();
    //SimonG.helpers.windowWatchers.updateWindowDimensions();

    jQuery.each(SimonG.services, function() {
        this.init();
    });
    jQuery.each(SimonG.widgets, function() {
        this.init();
    });
    jQuery.each(SimonG.helpers.polyfills, function() {
        //this.init();
    });

    $window.on('scroll resize', function() {
        //SimonG.helpers.lazyLoadImages();
    });
    $window.on('resize orientationchange', function() {
        //SimonG.helpers.windowWatchers.updateWindowDimensions();
        //picturefill();
        //SimonG.widgets.footer.check();
    });
   /*jQuery(see3Nm).on('load',function(){ //see3Nm is the provideSupport-generated JS object representing the dynamic script loaded to the page by their service. by watching its load event, we can adjust the footer height for changes made by the appeareance of 'online concierge' text.
        SimonG.widgets.footer.check();
   });*/
    $window.unload(function() {
        window.scrollTo(0, 0);
    });
    //jQuery('body.edit-mode').addClass('lotusui30dojo');
    //SimonG.helpers.lazyLoadImages();
};

var $footer, $footerToggle, $searchBox, $searchToggle, $map, $marqueeSlides, $slideshowLength, $slideHeight, $pagination, $marqueeNextButton, $marqueePrevButton, $checkBoxLabels, $radioButtonLabels, $mobileNav, $mobileNavToggle, $window, $footerLocationForm, $productDetails, $contestFrame, wishlist, $addWishlist, $removeWishlist, viewedProducts, $marquee, $filter, $filterForm, $filterToggle, $filterFeatureToggle, $filterFieldsets, $filterFieldsetContents, $filterReset, $retailerContact, $retailerContactList, $retailerContactSubmit, lastScrollPosition = SimonG.helpers.windowWatchers.windowScrollTop();

jQuery(function($) {
	/*if(typeof define === 'function' && define.amd){
		var reqConfig={
			packages: [
			  { name: "picturefill", location:SimonG.environment[currentEnvironment].picturefillPath, main:"picturefill" }
	        ]
		};
		require(reqConfig,['picturefill'],function(picturefill){
			if(!window.picturefill&&picturefill){window.picturefill=picturefill;}
			SimonG.init();
		});
	}else{
		jQuery('<script>').attr('type', 'text/javascript').attr('src',SimonG.environment[currentEnvironment].picturefillPath + '/picturefill.js').appendTo('head');
		SimonG.init();
	}*/
	SimonG.init();
});

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return (d*0.621371).toFixed(2);
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}
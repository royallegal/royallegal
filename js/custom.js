(function($) {
    var App = {
        currentScroll: 0,
        prevScroll: 0,
        direction: ''
    }

    $(document).ready(function() {
        $('.dashboard').click(function() {
            $(this).addClass('is-active');
        });

        // ---- Navigation ---- //
        nav();


        // ---- Hero ---- //
        if ($('body.home .video.trigger').length > 0) {
            heroVideo();
        }

        // ---- Forms ---- //
        $('.opt-out input').prop('checked', true);


        // ---- Media ---- //
        if ($('.page-id-864').length > 0) {
            preziWebinar();
        }


        // ---- Modals ---- //
        if ($('.modal').length > 0) {
            modals();
        }


        // ---- Cards ---- //
        if ($('.card').length > 0) {
            cards();
        }


        // ---- Contact ---- //
        if ($('.page-template-contact').length > 0) {
            contact();
        }


        // ---- Checkout ---- //
        if (window.location.href == "https://royallegalsolutions.com/quick-cart/"
            || window.location.href == "https://royallegalsolutions.com/checkout/") {
            setTimeout(function() {
                document.body.scrollTop = document.documentElement.scrollTop = 0;
            }, 1000);
        }


        // ---- UI ---- //
        // Disabled Links
        $('a.disabled').click(function(e) {
            e.preventDefault();
        });
        menus();


        // ---- Utility ---- //
        utility();
    });


    $(window).scroll(function() {
        var top = $(window).scrollTop();

        if ($('.home').length > 0) {
            var nav = $('nav');
            if (top > 5 && nav.hasClass('transparent')) {
                nav.removeClass('transparent');
            }
            else if (top < 5 && !nav.hasClass('transparent')) {
                nav.addClass('transparent');
            }
        }
    });


    // ---- NAVIGATION ---- //
    function nav() {
        // Mobile Nav
        $('nav .fa-bars').click(function() {
            $(this).parent().toggleClass('open');
        });

        // Dropdown Menus
        $('nav .item.trigger').click(function(e) {
            e.stopPropagation();
            $('nav .item.trigger').not($(this)).removeClass('open');
            $(this).toggleClass('open');
        });
        $('nav .sub.menu').click(function(e) {
            e.stopPropagation();
        });
        $(document).click(function() {
            $('nav .open.item.trigger').removeClass('open');
        });
    }


    // ---- HERO ---- //
    function heroVideo() {
        var button = $('.video.trigger');
        var container = '.' + button.prop('id');
        var video = document.getElementById("player");

        button.click(function(e) {
            e.stopPropagation();
            $(container).toggleClass('hidden');
            video.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
        });
        $('body').click(function() {
            $(container).addClass('hidden');
            video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
        });
    }


    // ---- MEDIA ---- //
    function preziWebinar() {
        var width = $('article iframe').css('width').replace('px','');
        var height = (.75 * parseInt(width)) + 35 + 'px';
        $('article iframe').css('height',height);
    }


    // ---- MODALS ---- //
    function modals() {
        var modal = $('.modal');
        
        modal.find('.container').click(function(e) {
            e.stopPropagation();
        });
        // Open
        $('.modal-trigger').click(function(e) {
            e.stopPropagation();
            modal.css('display','flex')
        });
        // Close
        $('body, .modal .close').click(function() {
            modal.hide();
        });
    }


    // ---- CARDS ---- //
    function cards() {
        var flipTrigger = $('[data-action="rotate"]');

        flipTrigger.click(function() {
            $('.flipper').toggleClass('rotate');
        });
    }


    // ---- VALIDATE ---- //
    // Contact Form
    function validateContact() {
        // Mask for fields
        $('input[name="phone"]').mask('000.000.0000');

        // Validation
        $('#contact-form').validate({
            onfocusout: function(e) {
	        this.element(e);
            },
            errorPlacement: function (error, element) {
                $(element).tooltipster('update', $(error).text());
                $(element).tooltipster('show');
            },
            success: function (label, element) {
                $(element).tooltipster('hide');
            },
            rules: {
	        iagree: "required",
                phone: { pattern: "[0-9]{3}.?[0-9]{3}.?[0-9]{4}" }
            },
            messages: { 
	        first: "First Name is Required",
	        last: "Last Name is Required",
	        phone: { pattern: "Enter valid format [XXX.XXX.XXXX]"} 
            }
        });

        // Tooltips for Validation
        var tipPosition = "";
        if (window.innerWidth <= 825 ) { tipPosition = "bottom"; } else { tipPosition = "bottom"; }
        $('input[type="text"], input[type="email"], input[type="tel"], input[name="iagree"], select').tooltipster({
            trigger:	'custom',
            onlyOne:	false,
            position:	tipPosition,
            theme:		'tooltipster-punk',
            offsetY:	-4,
            animation:	'grow',
            updateAnimation: false
        });
    }


    // ---- CONTACT ---- //
    function contact() {
        var square = $('iframe');
        var targets = ['#consultation-form','#webinar-form'];

        $(square).each(function(i,frame) {
            var elem = '#target ' + targets[i];
            $(frame).clone().appendTo($(elem));
            $(frame).remove();
        });

        var select = $('#form-controller');
        select.change(function() {
            var form = $(this).val();
            select.find('option:not(:disabled)').each(function(i,v) {
                var target = '#' + v.value + '-form';
                if (form == v.value) {
                    $('#target > div').hide();
                    $(target).show();
                }
            });
        });

        // Webinar Jam CSS
    }


    // ---- MENUS ---- //
    function menus() {
        var dropdown = $('.dropdown.menu');

        $('.menu-trigger').click(function(e) {
            e.stopPropagation();
            $('.dropdown.menu').addClass('hidden');
            $(this).find('.menu').toggleClass('hidden');
        });
        dropdown.click(function(e) {
            e.stopPropagation();
        });
        $('body').click(function() {
            $('.dropdown.menu').addClass('hidden');
        });
    }


    // ---- HELPER FUCTIONS ---- //
    function utility() {

        // Toggles all checkBoxes
        $(':checkbox[name="select-all"]').click(function() {
            $(':checkbox').prop("checked", this.checked);
            console.log('toggle');
        });
    }


    // ---- HELPER FUCTIONS ---- //
    // Detect Mobile
    function isMobile() {
        var isMobile = false;
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
           || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
        return isMobile;
    }

    // Crossbrowser for iOS
    function isIOS() {
        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        if (iOS) {
            return true;
        }
    }

    // Crossbrowser for IE
    function getIEVersion(){
        var agent = navigator.userAgent;
        var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
        var matches = agent.match(reg);
        var ua = window.navigator.userAgent;

        if (navigator.appVersion.indexOf("MSIE 8.") !== -1) {
            return 8;
        }
        if (navigator.appVersion.indexOf("MSIE 9.") !== -1) {
            return 9;
        }
        if (ua.indexOf("MSIE 10.") > 0) {
            return 10;
        }
        if (ua.indexOf("Trident/7.0") > 0) {
            return 11;
        }
        if (document.documentMode || /Edge/.test(navigator.userAgent)) {
            return 12;
        }
    }
})(jQuery);

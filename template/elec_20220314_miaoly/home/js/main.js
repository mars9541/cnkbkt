(function (jQuery) {
    jQuery.fn.hoverDelay = function (options) {
        var defaults = {
            hoverDuring: 500,
            outDuring: 200,
            hoverEvent: function () {
                jQuery.noop();
            },
            outEvent: function () {
                jQuery.noop();
            }
        };
        var sets = jQuery.extend(defaults, options || {});
        return jQuery(this).each(function () {
            var hoverTimer, outTimer;
            jQuery(this).hover(function (event) {
                var e = event;
                var t = this;
                clearTimeout(outTimer);
                hoverTimer = setTimeout(function () {
                    sets.hoverEvent(e, t)
                }, sets.hoverDuring);
            }, function (event) {
                var e = event;
                var t = this;
                clearTimeout(hoverTimer);
                outTimer = setTimeout(function () {
                    sets.outEvent(e, t)
                }, sets.outDuring);
            });
        });
    }
})(jQuery);

/*-- 回到顶部 --*/
var backTop = function () {
    var scrootp = jQuery(document).scrollTop();
    var Heig = document.documentElement.clientHeight;
    star(Heig, '.back-to-top')
    jQuery('.totop').click(function () {
        jQuery('body,html').scrollTop('0')
    })

    function star(a, b) {
        jQuery(window).scroll(function () {
            if (jQuery(document).scrollTop() > a) {
                jQuery(b).stop(true, true).show();
            } else {
                jQuery(b).stop(true, true).hide();
            }

            if (jQuery(document).scrollTop() > document.body.scrollHeight - document.body.clientHeight - 100) {
                if (jQuery(".work-list-box.hide").length > 0) {
                    var loadTime = 300 + parseInt(700 * Math.random());
                    jQuery("#page-loading").show();
                    setTimeout(function () {
                        jQuery("#page-loading").hide();
                        jQuery(".work-list-box.hide").removeClass("hide");
                        jQuery(".pageturning.hide").removeClass("hide");
                    }, loadTime);
                }
            }
        })
    }
}
backTop()


function navTypeTopFix() {
    var doc = jQuery(document);
    var tabNav = jQuery('.subnav-content-wrap');
    var tabNavOffsetTop = tabNav.position().top;
    var tabNavH = tabNav.height();
    var onoff = false;
    jQuery('.subnav-content-wrap').css('height', tabNav.height());
    window.onresize = function(){
            tabNavOffsetTop = tabNav.position().top;
    }
    jQuery(window).on('scroll', function (e) {
        
        if (jQuery('#confighome').is(":visible") == false) {
            if (doc.scrollTop() >= tabNavOffsetTop) {
                jQuery('.subnav-wrap').addClass('tab-nav-fixed')
            } else {
                jQuery('.subnav-wrap').removeClass('tab-nav-fixed');
            }
        } else {
            if (doc.scrollTop() >= tabNavOffsetTop + jQuery('#confighome').height()) {

                jQuery('.subnav-wrap').addClass('tab-nav-fixed')


            } else {
               jQuery('.subnav-wrap').removeClass('tab-nav-fixed');
            }
        }

    })

}

function hideGlobalMaskLayer() {
    jQuery('.shade').hide().removeClass('project-view');
    jQuery('html').removeClass('body-fixed')
    jQuery('.mask-layer').addClass('hide');
    jQuery('html').removeClass('scroll-fixed');
}
function showGlobalMaskLayer() {
    jQuery('.shade').show().addClass('project-view');
    jQuery('html').addClass('body-fixed');
    jQuery('html').addClass('scroll-fixed');
}


// 取消、关闭按钮 弹层消失
function confirmClose(obj) {
    obj.parents('.pop-up').hide();
    hideGlobalMaskLayer();
}
jQuery('.pop-up .pop-cancel,.pop-up .pop-close').on('click', function () {
    confirmClose(jQuery(this))
})


jQuery('.style-skin').on('click', function () {
    jQuery('.feedback-pop').show();
    showGlobalMaskLayer();
})


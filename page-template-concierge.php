<?php
/*
 * Template Name: Concierge
 */

get_header(); ?>
<?php 
    $hero = get_field('hero_image');
?>

    <section class="about concierge">
        <div class="container">
            <div class="header" style="background: url('<?php echo $hero['url']; ?>') no-repeat">
               
            </div>

            <h1>QUESTIONS? COMMENTS?</h1>
            <p class="sub-text">Simon G. Online Concierge Representatives are available Monday-Friday during business hours to help with any questions you may have.
Chat with a Simon G. Concierge now!</p>

            <span class="instruct">Click below to initiate a chat</span>

            <div id="cis12P" style="z-index: 100;position: absolute;"></div>
            <div id="scs12P" class="online_desk_link" style="display: none;">
                <a href="#" onclick="pss12Pow(); return false;">Online Concierge Desk</a>
            </div>
            <div id="sds12P" style="display:none">
                <script type="text/javascript" src="http://image.providesupport.com/js/0e7p9xx6pogu10up80o6nv1y67/safe-textlink.js?ps_h=s12P&amp;ps_t=1426539714968&amp;online-link-html=Online%20Concierge%20Desk%3C/span%3E%3C/h5%3E&amp;offline-link-html=Concierge%20Desk%20offline%3Cbr%3E%0A%3Cspan%3ELeave%20a%20message%3C/span%3E%3C/h5%3E"></script>
            </div>
            
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    $('.online_desk_link').css('display', 'block');
                });

            var ses12P=document.createElement("script");ses12P.type="text/javascript";var ses12Ps=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/0e7p9xx6pogu10up80o6nv1y67/safe-textlink.js?ps_h=s12P&ps_t="+new Date().getTime()+"&online-link-html=Online%20Concierge%20Desk%3C/span%3E%3C/h5%3E&offline-link-html=Concierge%20Desk%20offline%3Cbr%3E%0A%3Cspan%3ELeave%20a%20message%3C/span%3E%3C/h5%3E";setTimeout("ses12P.src=ses12Ps;document.getElementById('sds12P').appendChild(ses12P)",1);
            </script>
            <noscript>
                <div style="display:inline"><a href="http://www.providesupport.com?messenger=0e7p9xx6pogu10up80o6nv1y67" >Online Customer Service</a></div>
            </noscript>

            <p class="sub-text">To find a retailer near you, visit our Retailer Locator page. To return to viewing jewelry, <a href="/where-to-buy">click here</a>. </p>

        </div>
    </section>


<?php get_footer(); ?>
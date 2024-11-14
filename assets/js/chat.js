var ua = navigator.userAgent.toLowerCase(),
    platform = navigator.platform.toLowerCase();
platformName = ua.match(/ip(?:ad|od|hone)/) ? 'ios' : (ua.match(/(?:webos|android)/) || platform.match(/mac|win|linux/) || ['other'])[0],
    isMobile = /ios|android|webos/.test(platformName);

if (!isMobile) {
    //place your chat embed code here without the <script> tags
    window.$zopim||(function(d,s){var z=$zopim=function(c){
        z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='https://v2.zopim.com/?5y2sBHxsfg3iKOw6Dmg717nsnXVijAqN';z.t=+new Date;$.
        type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
}
/* When the user clicks on the button, 
			toggle between hiding and showing the dropdown content */
function myFunction2() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
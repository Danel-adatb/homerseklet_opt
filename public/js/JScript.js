function js_forced_ready(callback){
    if (document.readyState != 'loading') { callback(); }
    else if (document.addEventListener) { document.addEventListener('DOMContentLoaded', callback); }
    else
    {
        document.attachEvent('onreadystatechange', function() {
            if (document.readyState == 'complete') { callback(); }
        });
    }
}

$(document).ready(function() {
    js_forced_ready(function() {
        setTimeout(function() {
            test();
        }, 250);
    });
});

function test() {
    console.log('I am working!');
}
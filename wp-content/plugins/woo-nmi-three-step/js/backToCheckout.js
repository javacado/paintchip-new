function nmi701_backToCheckout(orderid, intervalid) {
    window.history.back();
}

function nmi701_timer(intervalid, length, counter) {
    //if the user waits too long, prompt them to go back
    if (typeof intervalid !== 'undefined') clearInterval(intervalid);
    var firststepdelay = 10000;
    var secondstepdelay = 30000;
    
    if (counter == 1) {
        var intervalid = setInterval(function(){
            timer('intervalid', firststepdelay, 2)
        },length);
    }
    else if (counter == 2) {
        document.getElementById('timeoutdsp').style.display = "block";
        var intervalid = setInterval(function(){
            timer('intervalid', secondstepdelay, 3);
        },length);
    }
    else if (counter == 3) {
        var intervalid = setInterval(function(){
            backToCheckout();
        },length);
    }
}

//run timer on page load
//if (typeof intervalid === 'undefined') timer('', 0, 1);
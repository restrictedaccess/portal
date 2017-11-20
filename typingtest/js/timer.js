
    var interval;

    function countdown(element) {
        interval = setInterval(function() {
            var el = document.getElementById(element);
            if(ttSec == 0) {
                if(ttMin == 0) {
                    //el.innerHTML = "Time's up!";
                    typtest.typing_finish();
                    //location.href='applicant_test.php';
                    return;
                } else {
                    ttMin--;
                    ttSec = 60;
                }
            }
            if(ttMin > 0) {
                var minute_text = ttMin > 9 ? ttMin : '0'+ ttMin;
            } else {
                var minute_text = '00';
            }
            
            //var second_text = seconds > 1 ? 'seconds' : 'second';
            el.innerHTML = minute_text + ':' + ttSec;// + ' ' + second_text;// + ' remaining';
            ttSec--;
        }, 1000);
    }

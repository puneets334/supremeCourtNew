 //refreshCaptcha();
function refreshCaptcha(){
    var CSRF_TOKEN = 'CSRF_TOKEN';
    var CSRF_TOKEN_VALUE = $('[name="_token"]').val();
    if(CSRF_TOKEN_VALUE){
        var img = document.images['captcha_image'];
        img.src = "/captcha/index?rand="+Math.random()*1000+'&CSRF_TOKEN='+CSRF_TOKEN_VALUE;
    }else{
        $('.text-red').html('The action you requested is not allowed (Invalid CSRF TOKEN)');
    }
}

function getCode() {
    var CSRF_TOKEN = 'CSRF_TOKEN';
    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
    $.ajax({
        url: "/captcha/DefaultController/get_code",
        cache: false,
        async: true,
        data: {
            CSRF_TOKEN:CSRF_TOKEN_VALUE,id: 'getCode',
        },
        type: 'get',
        success: function (data, status) {
            var resArr = data.split('@@@');
            if (resArr[0] == 1) {
                var CaptchaCode=resArr[1];
                if (CaptchaCode.length != 0){
                    $('#current_captcha_code').val(CaptchaCode);
                    $('#captcha_code').val(CaptchaCode);
                }else{
                    $('#playAudio').hide();
                    alert('Captcha code audio not found');
                }
            }else {

            }
        }
    });
}
function playAudio() {
    var CSRF_TOKEN = 'CSRF_TOKEN';
    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
    //var CSRF_TOKEN_VALUE=document.querySelector('input[name=CSRF_TOKEN]').value;
   // alert('CSRF_TOKEN_VALUE='+CSRF_TOKEN_VALUE);
    $.ajax({
        url: "/captcha/DefaultController/get_code",
        cache: false,
        async: true,
        data: {
            CSRF_TOKEN:CSRF_TOKEN_VALUE,id: 'getCode',
        },
        type: 'get',
        success: function (data, status) {
            var resArr = data.split('@@@');
            if (resArr[0]==1) {
                var CaptchaCode=resArr[1];
                //var CaptchaCode=$('#current_captcha_code').val();
                if (CaptchaCode.length != 0){
                        const { captcha, spokenText } = generateCaptcha(CaptchaCode);
                        console.log(captcha);
                        const msg = new SpeechSynthesisUtterance();
                        msg.text = `${spokenText}`;
                        msg.lang = 'en-US';
                        window.speechSynthesis.speak(msg);
                }else{
                    $('#playAudio').hide();
                    alert('Captcha code audio not found');
                }
            }else if (resArr[0]==0) {
                //alert(resArr[1]);
                $('.text-red').html(resArr[1]);
                //location.reload();
            }else {
                $('.text-red').html('The action you requested is not allowed (Invalid CSRF TOKEN)');
               // location.reload();
            }
        }
    });

}


function generateCaptcha(captcha) {
    const spokenText = Array.from(captcha)
        .map(char => {
            if(!isNaN(char)){
                return char;
            }
            // else{
                
            // }
            return (char === char.toUpperCase() ? `Capital ${char}` : (!isNaN(char)) ? char : `small ${char}`) ;
        })
        .join(", ");

    return { captcha, spokenText };
}

// function isInt(value) {
//     var x = parseFloat(value);
//     return !isNaN(value) && (x | 0) === x;
//   }
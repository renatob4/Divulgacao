// Se existir um mapa na page inicial este codigo altera seu tamanho para o padrão width=100% height=200;
var iframe = document.getElementsByTagName("iframe")[0];
if(iframe != null){
    iframe.setAttribute("width", "100%");
    iframe.setAttribute("height", 200);
}
//Div contendo o resultado de operações
var divresult = document.getElementById("resultado");
if(divresult != null){
    setTimeout(function() {
        $("#resultado").hide();
    }, 10000);
    //Da foco no resultado.
    window.location.hash = '#resultado';
}

//Script de acesso á API do facebook para receber resposta de compartilhamentos.
function share(url){

    FB.ui({
        method: 'share',
        display: 'popup',
        href: url,
    }, function(response){

    if(response.post_id !== 'undefined'){
        document.getElementById("nmc").setAttribute("placeholder", "");
        document.getElementById("nmc").disabled = false;
        document.getElementById("gcp").disabled = false;
        document.getElementById("gcp").style.backgroundColor = "green";
        document.getElementById("gcp").innerHTML = "";
        document.getElementById("gcp").innerHTML = "<b>GERAR CUPOM</b><i class='fas fa-check ml-2'></i>";
        document.getElementById("lbl").style.color = "green";
        document.getElementById("captcha").setAttribute("class", "g-recaptcha cap");
    }

  });
}
// Manipulação dos campos de configuração de promoções.
$(document).ready(function () {
    $('#type').change(function () {
        var op = document.getElementById('type');
        opValor = op.options[op.selectedIndex].value;
        switch (opValor) {
            case 'pc':

                document.getElementById("tag").innerHTML = "<b>%</b>";
                break;

            case 'vl':

                document.getElementById("tag").innerHTML = "R$";
                break;
        }
    });
});

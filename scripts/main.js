// Se existir um mapa na page inicial este codigo altera seu tamanho para o padrão width=100% height=200;
var iframe = document.getElementsByTagName("iframe")[0];
if(iframe != null){
    iframe.setAttribute("width", "100%");
    iframe.setAttribute("height", 200);
}

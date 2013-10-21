jQuery(document).ready(function($) {

    var filecontent, optimised;
    function nl2br(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }


// prendre la feuille de test et la placer dans la vue dans la div #unoptimised
    function loadXMLDoc(source, filecontent)
    {
        console.log('ajax de ' + source + 'lancé');
        $.ajax({
            url: source,
        })
                .done(function(data) {
            filecontent = data;

            $('#unoptimised').html(nl2br(data, false));
            return filecontent;
        });
    }

//optimisation
    //découpage en instructions du fichier
    function build(source, optimised) {
        console.log('build lancé');
        console.log('build: ' + source);

        $('#optimised').html('OOOOO' + optimised);
        return optimised;
    }

//lancement des actions
    filecontent = loadXMLDoc(source, filecontent)
    build(source, optimised);
// rendu dans la partie .optimised
    $("#optimised").html(optimised);

    var css = "a{    display: inline;}a{      display: inline-block;  }    a{      display: inline;      display: block;  }    b{      color: red;      display: inline;  }";
    console.log('essai  ' + css.length + '');

});

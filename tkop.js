jQuery(document).ready(function($) {

    window.filecontent;
    var optimised;
    var style;
    function nl2br(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

// prendre la feuille de test et la placer dans la vue dans la div #unoptimised
    css = $.ajax({
        url: "test.css",
    })
            .done(function(data) {
        filecontent = data;

        resultat = data.split('}');
        $('#log').append('<br/>result.length ').append(resultat.length);
        $('#log').append('<br/>').append(resultat);
        var style;
        $(resultat).each(function(index) {
            
            split = resultat[index].split('{');
            $('#log').append('<br/>').append(split[0]);
            $('#log').append('<br/>----').append(split[1]);
//            console.log(split[0]);
//            console.log(split[1]);
   // TODO prob de déclaration implicite de la variable style
//             style[index]['target'] = split[0] ;
//             style[index]['instructions'] = split[1];
        })
        console.log(style);
        console.log(resultat.length);
        $('#unoptimised').html(nl2br(data, false));
        return data;
    });

    $('#log').append('<br/>yeah');


//optimisation
    //découpage en instructions du fichier        
});

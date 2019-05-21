/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('input').click(function(){
        $(this).select();
    });

    $('#order-name').blur(function(){
        var name = $('#order-name').val().trim();
        var table = $('#table-num').text();

        if(name === ''){
            $('#alert').show();
        } else{
            $('#avanti-link').attr('href', '/ordinazioni/ordina.php?n='+name+'&t='+table);
        }
    });

    $('#btn-send').click(function(){
        var ordname = $('#nome-ordine').text();
        var tblnum = $('#numero-tavolo').text();
        var total = $('#num-total').text();
        var orderid = $('#id-ordine').text();
        var arrords = [];
        var text = '';
        var virgola = '';
        var nota = '';
        var newtxt = '';
        var newnota= '';
        var virgola_2 = '';
        //console.log($('#ordine').text());

        if($('#ordine').text()!==''){
            $('div', '#ordine').each(function(){
                arrords.push($(this).attr('id'));
            });

            if(arrords.lenght !== 0){
                for(var x = 0; x< arrords.length; x++){
                    if(x !== 0){
                        virgola = ',';
                        virgola_2 = '[';
                    }
                    console.log(arrords[x]);
                    newtxt = $('#'+arrords[x]).clone().find('#'+arrords[x].replace('ord', 'tot')).remove().end().text().slice(0, -1);
                    newnota = $('#'+arrords[x]+'-nota').text().trim();
                    console.log(newnota);
                    if(newnota || newnota!==''){
                        nota = nota+virgola_2+newnota;
                    }
                    text = text+virgola+newtxt;

                }

                $.post("send.php", {id: orderid, name: ordname, num: tblnum, tot: total, text: text, note: nota}, function (output){
                console.log(output);
                    if(output === ''){
                        $('#completed').show();
                        $('#indicazione-gluten').hide();
                        $('.indice').hide();
                        $('.tabs').hide();
                        $('.conto').hide();
                    } else{
                        $('#error').show();
                        $('#indicazione-gluten').hide();
                        $('.indice').hide();
                        $('.tabs').hide();
                        $('.conto').hide();
                    }
                });
            }
        }
    });


    $('.tabs input').blur(function(){
        if(!$(this).val().trim()){
            $(this).val('0');
        }

        setOrds($(this));
    });

    $('.tabs textarea').blur(function(){
        setOrds($(this));
    });
});

/*function refreshKitchen(sect){
    console.log('ORA!');
    $.post("r-kitchen.php", {s: sect}, function (output){
            console.log(output);
            $(".tabs").html(output);
            });
}*/

function setOrds(ogg){

        var id = ogg.attr('id');
        var arr = id.split('-');
        var numid = arr[arr.length-1];
        var type = arr[0];
        var nota = '';
        //$('#gluten').remove();
        /*$.fn.ignore = function(sel){
            return $('#'+type+'-q-'+numid).clone().find(sel||">*").remove().end();
        };*/

        var name = $('#'+type+'-n-'+numid)/*.ignore('#gluten')*/.text();

        var val = $('#'+type+'-q-'+numid).val().trim();

        console.log(type);

        if (type==='ham' || type === 'san'){
            nota = $('#'+type+'-i-'+numid).val();
        }

        var prez = parseFloat($('#'+type+'-p-'+numid).text()).toFixed(2);
        var preztot = parseFloat((prez*val).toFixed(2)).toFixed(2);

        var prectext = $('#ordine').html();
        var prectot = $('#num-total').text();
        if (prectot === '') {
            prectot = 0;
        } else{
            prectot = parseFloat(prectot).toFixed(2);
        }
        var prechidtxt = $('#hidorder').html();

        console.log(val);

        console.log(val, id, numid, type, name, prez, preztot, nota);

        if($('#ord-'+type+'-'+numid).length){
            if(val === '0' || val === ''){
                var tobemodiftot = parseFloat($('#tot-'+type+'-'+numid).text());

                var newtot = (parseFloat($('#num-total').text())*1)-(tobemodiftot*1);
                var totaletrue = ((newtot*1)+(preztot*1)).toFixed(2);

                $('#ord-'+type+'-'+numid+'-nota').remove();

                $('#totale').html("Totale: &#8364; <span id='num-total'>"+totaletrue+"</span>");
                $('#ord-'+type+'-'+numid).parent().nextUntil(':not(br)').remove();
                $('#ord-'+type+'-'+numid).remove();


            } else{
                var tobemodiftot = parseFloat($('#tot-'+type+'-'+numid).text());

                var newtot = (parseFloat($('#num-total').text())*1)-(tobemodiftot*1);
                var totaletrue = ((newtot*1)+(preztot*1)).toFixed(2);

                $('#totale').html("Totale: &#8364; <span id='num-total'>"+totaletrue+"</span>");
                $('#ord-'+type+'-'+numid+'-nota').text(nota);
                $('#ord-'+type+'-'+numid).html(name+" X"+val+" &#8364;"+prez+"<span style='margin-left: 10px; float: right; border-bottom: 1px solid black'>&#8364;<span id='tot-"+type+"-"+numid+"'>"+preztot+'</span></span>');
            }
        } else if(val !== '0'){
            var totale = ((prectot*1)+(preztot*1)).toFixed(2);

            var text = prectext+"<span id='ord-"+type+"-"+numid+"-nota' style='display: none;'>"+nota+"</span><div id='ord-"+type+"-"+numid+"' style='border-bottom: 1px solid black'><span style='font-style: italic;'>"+name+"</span> X"+val+" &#8364;"+prez+"<span style='margin-left: 10px; float: right; font-size: 1.8em;'>&#8364;<span id='tot-"+type+"-"+numid+"'>"+preztot+'</span></span></div><br>';
            $('#ordine').html(text);
            $('#totale').html("Totale: &#8364; <span id='num-total'>"+totale+"</span>");
        }
}

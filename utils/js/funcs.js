/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    setOrder();

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
      var order_data = {};
      order_data = JSON.parse(localStorage.getItem('order-data'));
      var order_prods = {}
      order_prods = JSON.parse(localStorage.getItem('order-prods'));

      //console.log(order_data,order_prods);
      if(!$.isEmptyObject(order_data) && !$.isEmptyObject(order_prods)){
        $.post('send.php', {'order-data': order_data, 'order-prods': order_prods}, function(res){

              // show the response
              $('#completed').show();
              $('#completed').html(res);
              //$('#indicazione-gluten').hide();
              $('.indice').hide();
              $('.tabs').hide();
              $('.conto').hide();

          }).fail(function() {

              // just in case posting your form failed
              alert( "C'è stato un errore..." );

          });
      }
    });


    /*$('.tabs .qta').blur(function(){
        if(!$(this).val().trim()){
            $(this).val('0');
        }

        var idprod = parseInt($(this).attr('data-idprod'),10);
        var qta = parseInt($(this).val(),10);

        var row = $(this).closest('tr');
        var idrow = row.attr('id');

        if(row.hasClass('row-conto')){ //se sto toccando un input nella tabella del conto
          var input = $('.tabs #'+idrow+' #input-qta-'+idprod);
          input.val(qta);
          if(qta===0){
            row.remove();
          }
        }else{ //se sto toccando in input dei prodotti
          var row_conto = $('#tb-conto #'+idrow);

          if(row_conto.length){ //controlla se la riga esiste già nel conto
            var input_conto = $('#tb-conto #'+idrow+' #conto-qta-'+idprod);
            if(qta === 0){
              row_conto.remove();
            }else{
              input_conto.val(qta);
            }
          } else{
            if(qta!==0){
              var copyTable = $('#tb-conto tbody');
              var cloneRow = row.clone(true,true);
              //console.log(idrow);
              copyTable.append(cloneRow);
              $('#tb-conto #'+idrow).addClass('row-conto');
              $('#tb-conto #'+idrow+' #input-qta-'+idprod).attr('id', 'conto-qta-'+idprod);
            }
          }
        }

        updateOrder(idprod,qta);
    });*/

    $('.qta-button').click(function(){
      var idprod = parseInt($(this).attr('data-idprod'),10);
      var op = $(this).attr('data-op');

      var input = $('#input-qta-'+idprod);
      var qta = parseInt(input.val(),10);
      qta = handleVal(qta,op);

      var row = $(this).closest('tr');
      var idrow = row.attr('id');

      if(row.hasClass('row-conto')){ //se sto toccando un input nel conto
        var input_conto = $('#tb-conto #'+idrow+' #conto-qta-'+idprod);

        if(qta>0){
          input.val(qta);
          input_conto.val(qta);
        }else{
          if(confirm("Rimuovere dal conto?")){
            input.val(qta);
            row.remove();
          }else{
            qta = 1;
          }
        }

      }else{ //se sto toccando un input dei prodotti
        var row_conto = $('#tb-conto #'+idrow);
        input.val(qta);

        if(row_conto.length){ //se la riga esiste già nel conto
          var input_conto = $('#tb-conto #'+idrow+' #conto-qta-'+idprod);
          input_conto.val(qta);
          if(qta===0){
            row_conto.remove();
          }
        } else{
          if(qta>0){
            var copyTable = $('#tb-conto tbody');
            var cloneRow = row.clone(true,true);
            //console.log(idrow);
            copyTable.append(cloneRow);
            $('#tb-conto #'+idrow).addClass('row-conto');
            $('#tb-conto #'+idrow+' #input-qta-'+idprod).attr('id', 'conto-qta-'+idprod);
          }
        }
      }
      updateOrder(idprod, qta);
    });

    /*$('.tabs textarea').blur(function(){
        setOrds($(this));
    });*/
});

function handleVal(qta,operator){
  if(operator === '+'){
    return qta + 1
  }else if(operator === '-'){
    if(qta>0){ //evita che si vada sotto lo 0
      return qta-1;
    }else{
      return qta;
    }
  }
}

function setOrder(){
  var ordname = $('#nome-ordine').text();
  var tblnum = parseInt($('#numero-tavolo').text(),10);
  var orderid = parseInt($('#id-ordine').text(),10);

  var newOrderData = {};
  newOrderData = {name: ordname, table: tblnum, idord: orderid};
  localStorage.setItem('order-data', JSON.stringify(newOrderData));

  var newOrderProds = {}
  localStorage.setItem('order-prods', JSON.stringify(newOrderProds));
}

function updateOrder(idprod,qta){
  var order = {}
  order = JSON.parse(localStorage.getItem('order-prods'));

  //console.log(order);
  if(qta>0){
    order[idprod] = qta;
  }else{
    delete order[idprod];
  }
  localStorage.setItem('order-prods', JSON.stringify(order));
}

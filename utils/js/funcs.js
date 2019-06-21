$(document).ready(function(){
    setOrder();

    $('input').click(function(){
        $(this).select();
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
              $('.indice').hide();
              $('.tabs').hide();

          }).fail(function() {

              // just in case posting your form failed
              alert( "C'è stato un errore..." );

          });
      }
    });

    $('.qta-button').click(function(){
      var prezzo = parseFloat($(this).attr('data-prezzo'));
      var idprod = parseInt($(this).attr('data-idprod'),10);
      var op = $(this).attr('data-op');

      var input = $('.input-qta-'+idprod); //casella con quantità (vale sia per il conto che per i prodotti perchè uso la classe come selector)

      var qta = parseInt(input.val(),10); //quantità del prodotto prima di premere il pulsante
      qta = handleVal(qta,op); //aggiorna la quantità

      var subTot = handlePrice(qta,prezzo); //subtotale del prodotto

      var totConto = parseFloat($('#tot-conto').text()); //totale del conto
      totConto = handleConto(totConto,prezzo,op); //aggiorna tot conto

      var row = $(this).closest('tr'); //trova la riga nella tabella del pulsante cliccato
      var idrow = row.attr('id'); //trova l'id della riga

      if(row.hasClass('row-conto')){ //**** SE STO TOCCANDO UN INPUT NEL CONTO ****

        if(qta>0){
          updateQta(input,qta); //aggiorna la grafica della quantità
          updateSubTot(input, subTot, idprod); //aggiorna la grafica del subtotale del prodotto
          updateOrderTot(totConto); //aggiorna la grafica del totale

        }else{
          if(confirm("Rimuovere dal conto?")){
            //quindi la qta=0 perchè è già stata aggiornata
            updateQta(input,qta); //aggiorna la grafica della quantità
            updateSubTot(input, subTot, idprod); //aggiorna la grafica del subtotale del prodotto
            updateOrderTot(totConto); //aggiorna la grafica del totale

            row.remove(); //togli la riga dalla tabella del conto
          }else{
            //non fare nulla, riaggiorna solo la qta a 1 perchè era stata decrementata a 0
            qta = 1;
          }
        }

      }else{ //**** SE STO TOCCANDO UN INPUT DEI PRODOTTI ****
        var row_conto = $('#tb-conto #'+idrow); //prendi la riga con id = idrow nella tabella del conto

        updateQta(input,qta); //aggiorna la grafica della quantità
        updateSubTot(input, subTot, idprod); //aggiorna la grafica del subtotale del prodotto
        updateOrderTot(totConto); //aggiorna la grafica del totale

        if(row_conto.length){ //se la riga esiste già nel conto
          if(qta===0){
            row_conto.remove(); //togli la riga dalla tabella del conto
          }
        } else{
          if(qta>0){
            var copyTable = $('#tb-conto tbody'); //tabella in cui copiare la riga
            var cloneRow = row.clone(true,true); //clona la riga copiando anche tutti gli eventi
            //console.log(idrow);
            copyTable.append(cloneRow); //attacca la riga alla tabella
            $('#tb-conto #'+idrow).addClass('row-conto'); //aggiungi la classe per renderla distinguibile dalla riga nei prodotti
          }
        }
      }
      updateOrder(idprod, qta);
    });
});

function showConto(){
  $('#prodotti').hide();
  $('.indice').hide();
  $('#conto').show();
}

function hideConto(){
  $('#prodotti').show();
  $('.indice').show();
  $('#conto').hide();
}

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

function handlePrice(qta,prezzo){
  //console.log(prezzo*qta);
  return (prezzo*qta).toFixed(2);
}

function handleConto(tot,price,operator){
  if(operator === '+'){
    return (tot + price).toFixed(2);
  }else if(operator === '-'){
    if(tot>0.0){ //evita che si vada sotto lo 0
      return (tot-price).toFixed(2);
    }else{
      return (tot).toFixed(2);
    }
  }
}

function updateQta(input,qta){
  input.val(qta); //aggiorna la grafica della quantità
}

function updateSubTot(input,subTot,idprod){
  input.attr('data-tot', subTot); //imposta il subtotale del prodotto
  $('.tot-'+idprod).text(subTot); //aggiorna la grafica del subtotale del prodotto
}

function updateOrderTot(totOrder){
  $('#tot-conto').text(totOrder); //aggiorna la grafica del conto
}

function setOrder(){
  var ordname = $('#nome-ordine').text();
  var tblnum = parseInt($('#numero-tavolo').text(),10);
  var orderid = parseInt($('#span-idord').text(),10);

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

function initButton(){
  var name = $('#order-name').val().trim();
  var table = $('#order-table').val().trim();

  if(name === ''){
      $('#alert').show();
      $('#alert').text('Inserisci un nome valido!');
  }else if(table===''){
      $('#alert').show();
      $('#alert').text('Inserisci un tavolo valido!');
  }else{
      $('#alert').hide();
      window.location.href = '/ordinazioni/ordina.php?n='+name+'&t='+table;
  }
}

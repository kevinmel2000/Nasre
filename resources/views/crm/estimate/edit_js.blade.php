<script>
  $(function(){
    "use strict";

    $('select').select2({
      width:'100%'
    });
    
  });

  var product_count = [];
  var row_id = 0;

  var estimate_relation = "Customer";

  if(estimate_relation == 'Customer'){
    getCustomers();
  }

  function getCustomers(){
    var customer_id = "{{$estimate->customer_id}}";
    var url="{{url('api/estimate/getCustomers')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'JSON',
      success: function (data) { 
        data.customers.forEach(customer => {
          if(customer_id == customer.id){
            var selected = 'selected';
          }else{
            var selected = '';
          }
            let tmp = `<option value="${customer.id}" ${selected}>${customer.username}</option>`;
            $('#customer_id').append(tmp);
          });
      }
    });    
  }

  estimateProducts();
  function estimateProducts(){
    var estimate_id = "{{@$estimate->id}}";
    url="{{url('api/estimate/getestimateProducts')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {estimate_id:estimate_id},
      dataType: 'JSON',
      success: function (data) { 
        row_id = data.estimate_products.length+1;
        data.estimate_products.forEach(product => {
          var product_row_id = product.id;
          product_count.push(product.id);
          var product_row = `
          <tr id = 'productRow${product_row_id}'>
            <td>
              <div class="form-group">
                <input type="text" name="product_name[]" class="form-control form-control-sm" value="${product.product_name}" required>
              </div>
            </td>
            <td>
              <div class="form-group">
                <input type="number" name="product_price[]" class="form-control form-control-sm" onchange="row_set_amount(${product_row_id})" onkeyup="row_set_amount(${product_row_id})" id="rowProductPrice${product_row_id}" value="${product.product_price}" required>
              </div>
            </td>
            <td>
              <div class="form-group">
                <input type="number" name="product_qty[]" class="form-control form-control-sm" onchange="row_set_amount(${product_row_id})" onkeyup="row_set_amount(${product_row_id})" id="rowProductQty${product_row_id}" value="${product.product_qty}" required>
              </div>
            </td>
            <td>
              <div class="form-group">
                <input type="number" name="product_tax[]" class="form-control form-control-sm"  onchange="row_set_amount(${product_row_id})" onkeyup="row_set_amount(${product_row_id})" id="rowProductTax${product_row_id}" step="0.02" value="${product.product_tax}" required>
              </div>
            </td>
            <td>
              <div class="form-group">
                <input type="text" name="product_amount[]" class="form-control form-control-sm" id="rowProductAmount${product_row_id}" value="${product.product_amount}" readonly/>
              </div>
            </td>
            <td>
              <div class="form-group">
              <button type="button" id="remove_product${product_row_id}" onclick="remove_product(${product_row_id})" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </button>
              </div>
            </td>
          </tr>        
          `;
        
          $('table#estimate_products').prepend(product_row);          
        });
        set_amount();
        setTotals();
      }
    });
  }

  // !SECTION GET Customers/Leads Ends

  $('#adjustments').on('keyup',()=>{
    setTotals();
  });
  $('#adjustments').on('change',()=>{
    setTotals();
  });

  $('#getDiscountTotal').on('keyup',()=>{
    setTotals();
  });
  $('#getDiscountTotal').on('change',()=>{
    setTotals();
  });

  $('#discount_type').on('change',()=>{
    setTotals();
  });

  

  
  $('#product_id').on('change',()=>{
    // function called inside
    var product_id = $('#product_id').val();
    url="{{url('api/estimate/getProduct')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      data: {product_id:product_id},
      dataType: 'JSON',
      success: function (data) { 
        $('#product_name').val(data.product.name);
        $('#product_price').val(data.product.price);
        $('#product_qty').val('1');
        set_amount();
      }
    });
  });

  $('#product_price').on('change',()=>{
    set_amount();
  });
  $('#product_price').on('keyup',()=>{
    set_amount();
  });
  $('#product_qty').on('change',()=>{
    set_amount();
  });
  $('#product_qty').on('keyup',()=>{
    set_amount();
  });
  $('#product_tax').on('change',()=>{
    set_amount();
  });
  $('#product_tax').on('keyup',()=>{
    set_amount();
  });

  // Calculate and append total amount including tax for a single product row 
  function set_amount(){
    // is a function
    const price = parseFloat($('#product_price').val());
    const qty = parseFloat($('#product_qty').val());
    const tax = parseFloat($('#product_tax').val());
    var price_without_tax = price*qty;

    var amount = price_without_tax+(price_without_tax*tax)/100;
    $('#product_amount').val(amount.toFixed(2));
  }

  // Add product in the estimate from the products list
  $('#add_product').on('click',()=>{
    // function called inside
    var product_name = $('#product_name').val();
    var product_price =  $('#product_price').val();
    var product_qty =  $('#product_qty').val();
    var product_tax =  $('#product_tax').val();
    var product_amount =  $('#product_amount').val();

    if(product_name == '' || product_price == '' || product_qty == '' || product_amount == ''){
      toastr.error('Please enter all the required fields.');
      return false;
    }

    row_id = row_id + 1;
    product_count.push(row_id);
    var product_row_id = row_id;
    var product_row = `
    <tr id = 'productRow${product_row_id}'>
      <td>
        <div class="form-group">
          <input type="text" name="product_name[]" class="form-control form-control-sm" value="${product_name}" required>
        </div>
      </td>
      <td>
        <div class="form-group">
          <input type="number" name="product_price[]" class="form-control form-control-sm" onchange="row_set_amount(${product_row_id})" onkeyup="row_set_amount(${product_row_id})" id="rowProductPrice${product_row_id}" value="${product_price}" required>
        </div>
      </td>
      <td>
        <div class="form-group">
          <input type="number" name="product_qty[]" class="form-control form-control-sm" onchange="row_set_amount(${product_row_id})" onkeyup="row_set_amount(${product_row_id})" id="rowProductQty${product_row_id}" value="${product_qty}" required>
        </div>
      </td>
      <td>
        <div class="form-group">
          <input type="number" name="product_tax[]" class="form-control form-control-sm"  onchange="row_set_amount(${product_row_id})" onkeyup="row_set_amount(${product_row_id})" id="rowProductTax${product_row_id}" step="0.02" value="${product_tax}" required>
        </div>
      </td>
      <td>
        <div class="form-group">
          <input type="text" name="product_amount[]" class="form-control form-control-sm" id="rowProductAmount${product_row_id}" value="${product_amount}" readonly/>
        </div>
      </td>
      <td>
        <div class="form-group">
        <button type="button" id="remove_product${product_row_id}" onclick="remove_product(${product_row_id})" class="btn btn-danger">
          <i class="fas fa-trash"></i>
        </button>
        </div>
      </td>
    </tr>        
    `;
   
    $('table#estimate_products').prepend(product_row);
    row_set_amount();
  })

  function row_set_amount(id){
    // is a function
    const price = parseFloat($('#rowProductPrice'+id).val());
    const qty = parseFloat($('#rowProductQty'+id).val());
    const tax = parseFloat($('#rowProductTax'+id).val());
    var price_without_tax = price*qty;
    var amount = price_without_tax+(price_without_tax*tax)/100;
    $('#rowProductAmount'+id).val(amount.toFixed(2));
    setTotals();
  }
  
  function remove_product(id){
    // is a function
    product_count = product_count.filter(element => element != id);
    $('#productRow'+id).remove();
    setTotals();
  }

  function setTotals(){
    // is a function
    var priceTotalWithoutTax = 0;
    var priceTotalWithTax = 0;
    var totalTaxOnly = 0;
    var discountTotal = 0;
    var adjust = 0;
    var totalAmount = 0;
    var temp_discountTotal = $('#getDiscountTotal').val();
    var totalDiscountAmount = 0;
    var adjustments = $('#adjustments').val();
    
    product_count.forEach(element => {
      // Get Price of each product row and store in temp_row_price 
      temp_row_price = parseFloat($('#rowProductPrice'+element).val())* parseInt($('#rowProductQty'+element).val());
      priceTotalWithoutTax = parseFloat(priceTotalWithoutTax) + parseFloat(temp_row_price);
      let rowProductAmount = $('#rowProductAmount'+element).val();
      priceTotalWithTax = parseFloat(priceTotalWithTax) + parseFloat(rowProductAmount);
      tmp_tax = (temp_row_price * parseFloat($('#rowProductTax'+element).val()))/100;
      totalTaxOnly = totalTaxOnly + tmp_tax;
    });
    
    if($('#discount_type').val() == 'Before Tax'){
      totalDiscountAmount = (parseFloat(priceTotalWithoutTax) * parseFloat(temp_discountTotal))/100;
      totalAmount = parseFloat(priceTotalWithoutTax) - totalDiscountAmount + parseFloat(adjustments) + parseFloat(totalTaxOnly);
    }else if($('#discount_type').val() == 'After Tax'){
      totalDiscountAmount = (parseFloat(priceTotalWithTax) * parseFloat(temp_discountTotal))/100;
      totalAmount = parseFloat(priceTotalWithoutTax) - totalDiscountAmount + parseFloat(adjustments) + parseFloat(totalTaxOnly);
    }
    $('#priceTotalWithTax').val(priceTotalWithTax.toFixed(2));
    $('#discount_total').val(totalDiscountAmount.toFixed(2));
    $('#total_amount').val(totalAmount.toFixed(2));
  }
</script>
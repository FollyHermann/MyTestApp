<script>

    $( document ).ready(function()
    {
        $("#startDate").datepicker({
            format: 'yyyy-mm-dd'
        });
        $("#endDate").datepicker({
            format: 'yyyy-mm-dd'
        });
        var today = moment().format('YYYY-MM-DD');
        $("#startDate").val(today);
        $("#endDate").val(today);
        get_transaction_list();
    });

    function get_transaction_list()
    {
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();

        if(new Date(start_date) <= new Date(end_date))
        {
            display_data(start_date, end_date);
        }
        else
        {
            show_error("La date de début doit etre inférieure à la date de fin");
        }

    }

    function display_data(start_date, end_date)
    {
        var dataInfo = {
            start_date : start_date,
            end_date : end_date,
            operation : "get_transaction_list"
        };
        $.ajax({
            type: "POST",
            url: 'app/functions.php',
            data: dataInfo,
            success: function(detail)
            {
                $("#transactions").html(detail);

            }
        });
    }
    
    function create_transaction()
    {
        $('#name').val('');
        $('#description').val('');
        $('#modal-add-transaction').modal('show', {backdrop: 'static'});
    }
    
    function delete_row()
    {

        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
        calculateTotalSupplying();
    }

    function add_to_cart()
    {
        var product_id = $('#id').val();
        var transaction_id = $('#transaction_id').val();

        var description = $('#product_id').find(":selected").text();
        var code = $('#product_id').find(":selected").data('text');
        var notes = $('#notes').val();
        var left_stock = $('#left_stock').val();
        var price = $('#sell_price').val();
        var quantity = $('#quantity').val();
        var total = quantity * price;
//if($('#transaction_id')[0].selectedIndex <= 0

        if($('#product_id option:selected').index() <= 0)
        {
            show_error("Vous devez choisir un produit");
            return;
        }
        if($('#transaction_id option:selected').index() <= 0)
        {
            show_error("Vous devez choisir un type de transaction");
            return;
        }

        if(quantity < 0 || quantity == "")
        {
            var err = "La quantité de la transaction doit être supérieure à 0";
            show_error(err);
            return;
        }

        if($('#transaction_id option:selected').index() == 2)
        {
            if(parseInt(quantity) > parseInt(left_stock))
            {
                show_error("Vous n'avez pas assez de quantité en stock pour cette transaction");
                return;
            }
        }
        if($('#transaction_id option:selected').index() == 3)
        {
            if(notes == "")
            {
                show_error("Une note est obligatoire quand vous faites un don");
                return;
            }
            if(quantity > left_stock)
            {
                show_error("Vous n'avez pas assez de quantité en stock pour cette transaction");
                return;
            }
        }

        add_product_list_to_row(code, description, price, quantity, total, notes, transaction_id)

    }

    function  add_product_list_to_row(code, description, price, quantity, total, notes, transaction_id)
    {
        //var i= $('#body-cart tr').length;
        var html = '<tr>';
        html += '<td style="display:none;">'+ notes +'</td>';
        html += '<td>'+ code +'</td>';
        html += '<td>' + description +'</td>';
        html += '<td>' + price +'</td>';
        html += '<td>' + quantity +'</td>';
        html += '<td class="totalLinePrice">' + total.toFixed(0) +'</td>';
        html += '<td style="display:none;">'+ transaction_id +'</td>';
        html += '<td align="center"><input class="case" type="checkbox"/></td>';
        html += '</tr>';
        $('#table-cart').append(html);
        // i++;
        calculateTotalTransaction();
        reset_form_field();
    }
    function reset_form_field() {
        $('#notes').val('');
        $('#left_stock').val('');
        $('#sell_price').val('');
        $('#quantity').val('');
        //$("#transaction_form select").val("-1");
    }

    function calculateTotalTransaction()
    {
        var totalTransaction = 0;

        $('.totalLinePrice').each(function()
        {
            totalTransaction += parseFloat( $(this).text());
        });
        $('#totalTransaction').val(totalTransaction);
    }

    function send_transaction_to_server()
    {
        var storedValues = store_table_data();
        var supply = {
            pTableData : $.toJSON(storedValues),
            operation : "create_transaction"
        };
        $.ajax({
            type: "POST",
            url: 'app/functions.php',
            data: supply,
            success: function(msg)
            {
                window.location.href=msg;
                $('#modal-add-selling').modal('hide');
            }
        });


    }
    function store_table_data() {
        var TableData = new Array();

        $('#body-cart tr').each(function(row, tr){
            TableData[row]={
                "notes" : $(tr).find('td:eq(0)').text()
                , "code" :$(tr).find('td:eq(1)').text()
                , "sell_price" : $(tr).find('td:eq(3)').text()
                , "quantity" : $(tr).find('td:eq(4)').text()
                , "total" : $(tr).find('td:eq(5)').text()
                , "transaction_id" : $(tr).find('td:eq(6)').text()
            }
        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }
    
</script>
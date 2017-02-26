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
        display_stock_inventory();
    });
   
    
    function display_stock_inventory()
    {
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();
    
        if(start_date == "" || end_date == "")
        {
            show_error("vous devez choisir une période");
            return;
        }
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
            operation : "get_inventory_details"
        };
        $.ajax({
            type: "POST",
            url: 'app/functions.php',
            data: dataInfo,
            success: function(detail)
            {
                $("#inventory").html(detail);
    
            }
        });
    }
   
</script>
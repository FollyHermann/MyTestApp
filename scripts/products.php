<?php
/**
 * Created by PhpStorm.
 * User: Hermann
 * Date: 21/02/2017
 * Time: 13:03
 */
?>
<script>
    var global_action, global_id;

    function save_product()
    {

        if($('#designation').val() == "")
        {
            show_error('La désignation est réquise');
            return;
        }

        if($('#sellprice').val() == "")
        {
            show_error("Le prix de vente est réquis");
            return;
        }

        if($('#buyprice').val() == "")
        {
            show_error("Le prix d'achat est réquis");
            return;
        }

        if($('#quantity').val() == "" && global_action == 1)
        {
            show_error('Le stock initial est 0 par défaut');
            return;
        }
        if($('#image').val() == "" && global_action == 1)
        {
            show_error("L'image de l'article est réquise");
            return;
        }

        validate_operation();

    }

    function create_product()
    {
        global_action = 1;
        $('#designation').val('');
        $('#quantity').val('');
        $('#buyprice').val('');
        $('#sellprice').val('');
        $('#modal-add-product').modal('show');
    }

    function validate_operation()
    {
        var designation = $("#designation").val();
        var dataInfo =
        {
            operation : "product_exist",
            designation : designation
        };
        $.ajax({
            type: "POST",
            url: 'app/functions.php',
            data: dataInfo,
            success: function(response)
            {
                if(response == "true")
                {
                    show_error("Ce produit existe déjà");
                }
                else
                {
                    switch (global_action)
                    {
                        case 1 :
                            $("#operation").val("create_product");
                            $("#form-add-product").submit();
                            break;
                        case 2 :
                            $("#operation").val("update_product");
                            $("#id").val(global_id);
                            $("#form-add-product").submit();
                            break;
                    }

                }
            }
        });
    }

    function update_product(id)
    {
        global_action = 2;
        global_id = id;

        $('#modal-add-product').modal('show', {backdrop: 'static'});
        $('#quantity').prop('disabled', true);

        var dataInfo = {
            id : id,
            operation : "get_details_product"
        };

        $.ajax({
            type: "POST",
            dataType : 'json',
            url: 'app/functions.php',
            data: dataInfo,
            success: function(detail)
            {
                $('#designation').val(detail.designation);
                $('#buyprice').val(detail.buy_price);
                $('#sellprice').val(detail.sell_price);
            }
        });

    }
    

</script>
